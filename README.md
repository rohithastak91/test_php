# test_php
Generate short url for any entered URL.

This project contains two basic php files. 
1. Test.php which include front end code, that is more of a UI part.
2. function.php which is used for interacting with DB as well as contains the main logic.

for database setup, You need to create on DB and insert one table called "url_mapping", schema is defined below:

CREATE TABLE `url_mappings` (
  `id` bigint(20) NOT NULL,
  `url` varchar(255) NOT NULL,
  `short_url` varchar(255) NOT NULL,
  `status` tinyint(5) NOT NULL,
  `created` datetime NOT NULL,
  `no_of_hits` int(25) NOT NULL
)

which will be used to save URLs as well as short code which will be used to redirect that to that URL.
You need to keep both the mentioned files in a folder on server and run test.php to get the desired output.






