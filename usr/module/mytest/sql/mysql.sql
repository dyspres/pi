# Quote all table names with '{' and '}', and prefix all system tables with 'core.'

CREATE TABLE `{contactus}` (
  `id`            int(10) unsigned        NOT NULL auto_increment,
  `username`      varchar(255)            NOT NULL default '',
  `gender`        tinyint(1)              NOT NULL default '1',
  `email`         varchar(255)            NOT NULL default '',
  `telephone`     varchar(255)            NOT NULL default '',
  `company`       varchar(255)            NOT NULL default '',
  `note`          text                             default '',
  `create_at`     int(11) unsigned        NOT NULL default '0',
  PRIMARY KEY  (`id`)
);