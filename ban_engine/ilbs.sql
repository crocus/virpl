# phpMyAdmin MySQL-Dump
# version 2.2.6
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Хост: localhost
# Время создания: Авг 23 2002 г., 10:30
# Версия сервера: 3.23.49
# Версия PHP: 4.1.2
# БД : `igrayru`
# --------------------------------------------------------

#
# Структура таблицы `ibs_acc`
#

DROP TABLE IF EXISTS ibs_acc;
CREATE TABLE ibs_acc (
  aid int(3) NOT NULL auto_increment,
  aname char(100) NOT NULL default '',
  PRIMARY KEY  (aid),
  KEY aid (aid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `ibs_ban`
#

DROP TABLE IF EXISTS ibs_ban;
CREATE TABLE ibs_ban (
  id int(6) NOT NULL auto_increment,
  link varchar(150) NOT NULL default '',
  image varchar(150) NOT NULL default '',
  alt varchar(150) NOT NULL default '',
  htm text NOT NULL,
  acc int(3) NOT NULL default '0',
  w int(3) NOT NULL default '0',
  h int(3) NOT NULL default '0',
  percent int(3) NOT NULL default '0',
  s int(20) NOT NULL default '0',
  p varchar(10) NOT NULL default '0',
  t char(2) NOT NULL default 'u',
  z int(3) NOT NULL default '0',
  b varchar(10) NOT NULL default '0',
  rdate datetime NOT NULL default '0000-00-00 00:00:00',
  sdate datetime NOT NULL default '0000-00-00 00:00:00',
  view int(10) NOT NULL default '0',
  click int(10) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY id (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `ibs_pos`
#

DROP TABLE IF EXISTS ibs_pos;
CREATE TABLE ibs_pos (
  pid char(12) NOT NULL default '',
  pname char(100) NOT NULL default '',
  PRIMARY KEY  (pid),
  KEY pid (pid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `ibs_sites`
#

DROP TABLE IF EXISTS ibs_sites;
CREATE TABLE ibs_sites (
  sid int(3) NOT NULL auto_increment,
  sname char(100) NOT NULL default '',
  url char(100) NOT NULL default '',
  view int(10) NOT NULL default '0',
  click int(10) NOT NULL default '0',
  KEY sid (sid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `ibs_stats`
#

DROP TABLE IF EXISTS ibs_stats;
CREATE TABLE ibs_stats (
  id int(8) NOT NULL auto_increment,
  bid int(3) NOT NULL default '0',
  d date NOT NULL default '0000-00-00',
  s int(3) NOT NULL default '0',
  p char(10) NOT NULL default '',
  z int(3) NOT NULL default '0',
  t int(3) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `ibs_zones`
#

DROP TABLE IF EXISTS ibs_zones;
CREATE TABLE ibs_zones (
  zid int(3) NOT NULL auto_increment,
  sid int(3) NOT NULL default '0',
  zname char(100) NOT NULL default '',
  ztemplate char(100) NOT NULL default '',
  view int(10) NOT NULL default '0',
  click int(10) NOT NULL default '0',
  KEY zid (zid)
) TYPE=MyISAM;

#
# Дамп данных таблицы `ibs_pos`
#

INSERT INTO ibs_pos VALUES ('top', 'Верх страницы');
INSERT INTO ibs_pos VALUES ('middle', 'Середина страницы');
INSERT INTO ibs_pos VALUES ('bottom', 'Низ страницы');
