====================
 OpenTracker
 revised 7-Feb-2005
====================

To run OpenTracker, you need two things: a web server that supports PHP, and a MySQL database.

PHP should be set for magic_quotes_gpc off.

Execute the included dbschema.sql on your database. This will create the table required by OpenTracker, which is named `peers` by default. You may rename the table if desired.

Edit config.inc.php, filling in the appropriate information for your database setup.

That's all there is to it. Create a torrent using announce.php on your server as the announce URL, and away you go.
