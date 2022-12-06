# simpleBBS

## Create SQL Table(s)
```
CREATE TABLE board (
  post_id int(11) unsigned NOT NULL auto_increment, 
  name varchar(20) NOT NULL, 
  email varchar(30), 
  password varchar(16) NOT NULL, 
  title varchar(70) NOT NULL, 
  content text NOT NULL, 
  wdate datetime NOT NULL, 
  ip_addr varchar(16) NOT NULL, 
  views int(11) NOT NULL default '0', 
  PRIMARY KEY (post_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
```

## License Information
This repository is licensed under GPL v2.
