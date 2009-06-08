-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2009 年 06 月 08 日 17:49
-- 服务器版本: 5.0.41
-- PHP 版本: 5.2.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 数据库: `ader`
--

-- --------------------------------------------------------

--
-- 表的结构 `guestbook`
--

CREATE TABLE IF NOT EXISTS `guestbook` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uname` char(15) NOT NULL default 'guest',
  `email` char(15) NOT NULL,
  `website` char(20) NOT NULL,
  `content` longtext NOT NULL,
  `uip` char(15) NOT NULL,
  `hidden` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `uname` (`uname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `guestbook`
--

