-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 24. Nov 2013 um 22:06
-- Server Version: 5.6.12
-- PHP-Version: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `microblog`
--
CREATE DATABASE IF NOT EXISTS `microblog` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `microblog`;

--
-- Daten für Tabelle `Blog`
--

INSERT INTO `Blog` (`id`, `title`) VALUES
(1, 'My Blog 1'),
(2, 'Blog 2'),
(3, 'Blog 3');

--
-- Daten für Tabelle `Comment`
--

INSERT INTO `Comment` (`id`, `postId`, `content`) VALUES
(1, 1, 'Comment 1'),
(2, 1, 'Comment 2'),
(3, 1, 'Comment 3'),
(4, 2, 'Comment 4'),
(5, 2, 'Comment 5'),
(6, 2, 'Comment 6'),
(7, 3, 'Comment 7'),
(8, 4, 'Comment 8');

--
-- Daten für Tabelle `Post`
--

INSERT INTO `Post` (`id`, `blogId`, `content`) VALUES
(1, 1, 'Post 1-1'),
(2, 1, 'Post 1-2'),
(3, 1, 'Post 1-3'),
(4, 2, 'Post 2-1'),
(5, 2, 'Post 2-2'),
(6, 2, 'Post 2-3'),
(7, 2, 'Post 2-4'),
(8, 3, 'Post 3-1'),
(9, 3, 'Post 3-2');
