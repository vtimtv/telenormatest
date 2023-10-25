
drop table if exists users;
CREATE TABLE `users` (
 `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `fname` varchar(100) COLLATE utf8_bin NOT NULL,
 `lname` varchar(100) COLLATE utf8_bin NOT NULL,
 `position` int(10) UNSIGNED NOT NULL,
 `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
