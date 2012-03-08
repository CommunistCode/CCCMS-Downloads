<?
/*
 * OpenTracker
 * revised 16-Feb-2005
 * revised 23-Apr-2009: removed RTRIM on BINARY column comparisons
 */

require_once 'bencoding.inc.php';
require_once 'config.inc.php';

function errorexit($reason) {
	exit(bencode(array('failure reason' => $reason)));
}

header('Content-Type: text/plain');

// connect to database
@mysql_pconnect($db_server, $db_user, $db_pass) or errorexit('database unavailable');
@mysql_select_db($db_db) or errorexit('database unavailable');

// calculate scrape interval
$query = @mysql_query("SELECT COUNT(*) FROM `$db_table` WHERE `expire_time` > NOW();") or errorexit('database error');
$num_peers = mysql_result($query, 0);
$query = @mysql_query("SELECT COUNT(*) FROM `$db_table` WHERE `update_time` > NOW() - INTERVAL 1 MINUTE;") or errorexit('database error');
$announce_rate = mysql_result($query, 0);
$scrape_interval = max($num_peers * $announce_rate / ($max_announce_rate * $max_announce_rate) * 60, $min_announce_interval) * $scrape_factor;

// determine which info hashes to scrape
if (empty($_GET['info_hash'])) {
	$hashes = array();
	$query = @mysql_query("SELECT DISTINCT `info_hash` FROM `$db_table` WHERE `expire_time` > NOW()") or errorexit('database error');
	while ($row = mysql_fetch_row($query)) {
		$hashes[] = $row[0];
	}
}
else {
	parse_str(str_replace('info_hash=', 'info_hash[]=', $_SERVER['QUERY_STRING']), $array);
	$hashes = $array['info_hash'];
}

// retrieve statistics for each desired info hash
$files = array();
foreach ($hashes as $hash) {
	$hash_escaped = mysql_escape_string($hash);
	$query = @mysql_query("SELECT COUNT(*) FROM `$db_table` WHERE `info_hash` = '$hash_escaped' AND `left` = 0 AND `expire_time` > NOW()") or errorexit('database error');
	$complete = intval(mysql_result($query, 0));
	$query = @mysql_query("SELECT COUNT(*) FROM `$db_table` WHERE `info_hash` = '$hash_escaped' AND `left` > 0 AND `expire_time` > NOW()") or errorexit('database error');
	$incomplete = intval(mysql_result($query, 0));
	$query = @mysql_query("SELECT COUNT(DISTINCT ip, port) FROM `$db_table` WHERE `info_hash` = '$hash_escaped' AND `left` = 0") or errorexit('database error');
	$downloaded = intval(mysql_result($query, 0));
	$files[$hash] = array('complete' => $complete, 'incomplete' => $incomplete, 'downloaded' => $downloaded);
}

// return data to client
exit(bencode(array('files' => $files, 'flags' => array('min_request_interval' => intval($scrape_interval)))));
?>
