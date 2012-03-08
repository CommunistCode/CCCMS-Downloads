<?
// Parameters for database connection and queries
$db_server = 'localhost';
$db_user = 'pimpmypi';
$db_pass = 'raspberryinabigbasket';
$db_db = 'pimpmypi';
$db_table = 'peers';

/*
 * Peers should wait at least this many seconds between announcements
 */
$min_announce_interval = 900; // seconds

/*
 * Maximum desired announcements per minute for all peers combined
 * (announce interval will be increased if necessary to achieve this)
 */
$max_announce_rate = 500; // announcements per minute

/*
 * Consider a peer dead if it has not announced in a number of seconds equal
 * to this many times the calculated announce interval at the time of its last
 * announcement (must be greater than 1; recommend 1.2)
 */
$expire_factor = 1.2;

/*
 * Peers should wait at least this many times the current calculated announce
 * interval between scrape requests
 */
$scrape_factor = 0.5;

/*
 * Should we require a certain announce protocol?
 *   "standard" allows all protocols
 *   "no_peer_id" allows only no_peer_id and compact
 *   "compact" allows only compact
 */
$require_announce_protocol = 'standard';

?>
