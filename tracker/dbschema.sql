#
# OpenTracker
# revised 11-Sep-2004
# revised 23-Apr-2009: `info_hash` and `peer_id` are of BINARY type
#

DROP TABLE IF EXISTS `peers`;
CREATE TABLE `peers` (
  `info_hash` binary(20) NOT NULL,
  `ip` int(11) NOT NULL,
  `port` smallint(5) unsigned NOT NULL,
  `peer_id` binary(20) NOT NULL,
  `uploaded` bigint(20) unsigned NOT NULL default '0',
  `downloaded` bigint(20) unsigned NOT NULL default '0',
  `left` bigint(20) unsigned NOT NULL default '0',
  `update_time` timestamp NOT NULL,
  `expire_time` timestamp NOT NULL,
  PRIMARY KEY  (`info_hash`,`ip`,`port`)
) ENGINE=MEMORY;
