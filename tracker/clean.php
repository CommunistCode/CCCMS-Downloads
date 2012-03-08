<?
require_once 'config.inc.php';

mysql_connect($db_server, $db_user, $db_pass);
mysql_select_db($db_db);
mysql_query("DELETE FROM `$db_table` WHERE `expire_time` < NOW() - INTERVAL 3 DAY");
?>
