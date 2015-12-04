-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2014 at 02:21 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `t2b`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL DEFAULT '0',
  `image` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `entityId` int(11) NOT NULL DEFAULT '0',
  `seqNo` int(11) NOT NULL DEFAULT '0',
  `timeStamp` int(11) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT '1',
  `special` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `image`, `comment`, `entityId`, `seqNo`, `timeStamp`, `rating`, `special`) VALUES
(1, 'store/img-1.jpg', 'The Blade of Grass is a sword made with certain materials from the Underground Jungle. It has the second longest melee range in the game (second only to the Breaker Blade). The Blade of Grass is able to hit monsters that are behind your character. The Blade of Grass is also a good weapon to use against the Eye of Cthulhu due to its relatively easy accessibility, wide arc of fire, and ability to poison. The Blade of Grass is one of the four swords required to craft Night''s Edge. ', 1, 1, 1390750448, 1, 0),
(2, 'store/img-2.jpg', 'The Blade of Grass''s sprite has changed, as can be seen in this picture. Does anyone have a picture of the correct sprite so the wiki page can be updated?', 1, 2, 1391359326, 1, 1),
(3, '', 'Lol, I love how HERO says the Blade of Grass has a long range, and I get the "Large" Prefix! so it''s even longer x)\r\n\r\nBTW my picture is fan art of Hallowed Armor, Demon Wings (I think) Gungir ( I think) and the Mega Shark', 1, 3, 1390749666, 2, 0),
(5, 'store/img-5.jpg', 'Sir Alex', 4, 1, 1390750050, 1, 1),
(6, 'store/img-6.jpg', '', 5, 1, 1390752496, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `entity`
--

CREATE TABLE IF NOT EXISTS `entity` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(100) NOT NULL,
  `commentList` varchar(100) NOT NULL,
  `tags` varchar(100) NOT NULL,
  `nxtSeqNo` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `level` int(11) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT '1',
  `special` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `entity`
--

INSERT INTO `entity` (`id`, `title`, `description`, `type`, `commentList`, `tags`, `nxtSeqNo`, `created`, `updated`, `status`, `level`, `rating`, `special`) VALUES
(1, 'The dawn of the second Brain 2', 'Knowledge management (KM) is the process of capturing, developing, sharing, and effectively using organisational knowledge.It refers to a multi-disciplined approach to achieving organisational objectives by making the best use of knowledge.', 'gen', '1,2,3', 'first,t2b,knowledgeMgmt', 4, 1390747844, 1401639798, 'open', 1, 1, 0),
(3, 'History of Islam', 'Muslims believe that God is one and incomparable [2] and the purpose of existence is to submit to and serve Allah (God).[3] Muslims also believe that Islam is the complete and universal version of a primordial faith that was revealed before many times throughout the world, including notably through Adam, Noah, Abraham, Moses and Jesus, whom they consider prophets.[4] They maintain that the previous messages and revelations have been partially misinterpreted or altered over time,[5] but consider the Arabic Qur''an to be both the unaltered and the final revelation of God.[6] Religious concepts and practices include the five pillars of Islam, which are basic concepts and obligatory acts of worship, and following Islamic law, which touches on virtually every aspect of life and society, providing guidance on multifarious topics from banking and welfare, to warfare and the environment.', 'islam', '', 'islam,religion', 1, 1390749906, 1390751610, 'open', 1, 1, 0),
(4, 'Sir Alex', 'Sir Alexander Chapman "Alex" Ferguson, CBE (born 31 December 1941) is a former Scottish football manager and player who managed Manchester United from 1986 to 2013. His time at the club has led to Ferguson being regarded as one of the most successful, admired and respected managers in the history of the game.But his greatest mistake was to hire arsehole moyes, who destroyed united', 'footy', '5', 'saf,mutd', 2, 1390750017, 1390752264, 'closed', 1, 5, 1),
(5, 'Gaming', 'Such wow,Much graphics, very violent, much doge', 'tech', '6', 'games,graphics,deadpool', 2, 1390752433, 1390756584, 'open', 1, 1, 1),
(6, 'Just a test Post', 'Sunderland hand a debut to Liam Bridcutt at the expense of Seb Larsson in the only change from the side that beat Stoke City.', 'footy', '', 'test,mutd,games,t2b,lms,ffs,theSecondBrain,fpl,soManyTags', 1, 1391260641, 1391260641, 'pend', 2, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `statics`
--

CREATE TABLE IF NOT EXISTS `statics` (
  `id` int(11) NOT NULL DEFAULT '0',
  `nxtEntity` int(11) NOT NULL DEFAULT '1',
  `nxtComment` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `statics`
--

INSERT INTO `statics` (`id`, `nxtEntity`, `nxtComment`) VALUES
(0, 8, 9);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entityId` int(11) NOT NULL,
  `tag` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `entityId`, `tag`) VALUES
(1, 1, 'first'),
(2, 1, 't2b'),
(3, 1, 'knowledgeMgmt'),
(7, 3, 'islam'),
(8, 3, 'religion'),
(9, 4, 'saf'),
(10, 4, 'mutd'),
(11, 5, 'games'),
(12, 5, 'graphics'),
(14, 5, 'deadpool'),
(15, 6, 'test'),
(16, 6, 'mutd'),
(17, 6, 'games'),
(18, 6, 't2b'),
(19, 6, 'lms'),
(20, 6, 'ffs'),
(21, 6, 'theSecondBrain'),
(22, 6, 'fpl'),
(23, 6, 'soManyTags');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
