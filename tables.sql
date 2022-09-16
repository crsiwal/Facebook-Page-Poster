CREATE TABLE user (
  ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique unique id',
  username VARCHAR(128) NOT NULL DEFAULT '' COMMENT 'user username',
  pass VARCHAR(128) NOT NULL DEFAULT '' COMMENT 'user password',
  accesstoken VARCHAR(1024) NOT NULL DEFAULT '' COMMENT 'user post access token',
  pages longtext NOT NULL DEFAULT '' COMMENT 'user pages list',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user` (`ID`, `username`, `pass`, `accesstoken`, `pages`) VALUES (1, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', '', '');