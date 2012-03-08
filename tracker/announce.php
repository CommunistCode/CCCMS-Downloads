<?
/*
 * OpenTracker
 * revised 16-Feb-2005
 * revised 23-Apr-2009: remove RTRIM for BINARY column comparisons
 */

require_once 'bencoding.inc.php';
require_once 'config.inc.php';

function errorexit($reason) {
	exit(bencode(array('failure reason' => $reason)));
}

function resolve_ip($host) {
	$ip = ip2long($host);
	if (($ip === false) || ($ip == -1)) {
		$ip = ip2long(gethostbyname($host));
		if (($ip === false) || ($ip == -1)) {
			return false;
		}
	}
	return $ip;
}

header('Content-Type: text/plain');

// validate request
if (empty($_GET['info_hash']) || empty($_GET['port']) || !is_numeric($_GET['port']) || empty($_GET['peer_id']) || !isset($_GET['uploaded']) || !is_numeric($_GET['uploaded']) || !isset($_GET['downloaded']) || !is_numeric($_GET['downloaded']) || !isset($_GET['left']) || !is_numeric($_GET['left']) || (!empty($_GET['event']) && ($_GET['event'] != 'started') && ($_GET['event'] != 'completed') && ($_GET['event'] != 'stopped'))) {
	errorexit('invalid request (see http://bitconjurer.org/BitTorrent/protocol.html)');
}

// is the announce method allowed?
if ($require_announce_protocol == 'no_peer_id') {
	if (empty($_GET['compact']) && empty($_GET['no_peer_id'])) {
		errorexit('standard announces not allowed; use no_peer_id or compact option');
	}
}
else if ($require_announce_protocol == 'compact') {
	if (empty($_GET['compact'])) {
		errorexit('tracker requires use of compact option');
	}
}

// convert dotted decimal or host name to integer IP
$ip = resolve_ip(empty($_GET['ip']) ? $_SERVER['REMOTE_ADDR'] : $_GET['ip']);
if ($ip === false) {
	errorexit("unable to resolve host name $_GET[ip]");
}

// connect to database
@mysql_pconnect($db_server, $db_user, $db_pass) or errorexit('database unavailable');
@mysql_select_db($db_db) or errorexit('database unavailable');

// calculate announce interval
$query = @mysql_query("SELECT COUNT(*) FROM `$db_table` WHERE `expire_time` > NOW();") or errorexit('database error');
$num_peers = mysql_result($query, 0);
$query = @mysql_query("SELECT COUNT(*) FROM `$db_table` WHERE `update_time` > NOW() - INTERVAL 1 MINUTE;") or errorexit('database error');
$announce_rate = mysql_result($query, 0);
$announce_interval = max($num_peers * $announce_rate / ($max_announce_rate * $max_announce_rate) * 60, $min_announce_interval);

// calculate expiration time offset
if (!empty($_GET['event']) && ($_GET['event'] == 'stopped')) {
	$expire_time = 0;
}
else {
	$expire_time = $announce_interval * $expire_factor;
}

// insert/update peer in database
$columns = '`info_hash`, `ip`, `port`, `peer_id`, `uploaded`, `downloaded`, `left`, `expire_time`';
$values = '\'' . mysql_escape_string($_GET['info_hash'])  . '\', ' . $ip . ', ' . $_GET['port'] . ', \'' . mysql_escape_string($_GET['peer_id']). '\', ' . $_GET['uploaded'] . ', ' . $_GET['downloaded'] . ', ' . $_GET['left'] . ", NOW() + INTERVAL $expire_time SECOND";
@mysql_query("REPLACE INTO `$db_table` ($columns) VALUES ($values);") or errorexit('database error');

// retrieve peers from database
$peers = array();
$numwant = empty($_GET['numwant']) ? 50 : intval($_GET['numwant']);
$query = @mysql_query("SELECT `ip`, `port`, `peer_id` FROM `$db_table` WHERE `info_hash` = '" . mysql_escape_string($_GET['info_hash']) . "' AND `expire_time` > NOW() ORDER BY RAND() LIMIT $numwant;") or errorexit('database error');
if (!empty($_REQUEST['compact'])) {
	$peers = '';
	while ($array = mysql_fetch_assoc($query)) {
		$peers .= pack('Nn', $array['ip'], $array['port']);
	}
}
else if (!empty($_REQUEST['no_peer_id'])) {
	while ($array = mysql_fetch_assoc($query)) {
		$peers[] = array('ip' => long2ip($array['ip']), 'port' => intval($array['port']));
	}
}
else {
	while ($array = mysql_fetch_assoc($query)) {
		$peers[] = array('ip' => long2ip($array['ip']), 'port' => intval($array['port']), 'peer id' => $array['peer_id']);
	}
}

// return data to client
exit(bencode(array('interval' => intval($announce_interval), 'peers' => $peers)));
?>
