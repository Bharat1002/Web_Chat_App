-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2022 at 01:49 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webchatapp`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `spAddMember` (IN `user_id` INT, IN `usr_add` INT)   BEGIN
INSERT INTO grpmember(group_id, member_id)
VALUES(user_id, usr_add);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spChat` (IN `o_id` INT, IN `i_id` INT)   BEGIN
SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id WHERE (outgoing_msg_id=o_id AND incoming_msg_id=i_id) OR (outgoing_msg_id=i_id AND incoming_msg_id=o_id) ORDER BY msg_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spCheckAdmin` (IN `gr_id` INT, IN `ad_id` INT)   BEGIN
SELECT * FROM grpadmin WHERE group_id=gr_id AND admin_id=ad_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spCheckMail` (IN `e_mail` VARCHAR(255))   BEGIN
SELECT * FROM users WHERE email=e_mail;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spCheckMember` (IN `g_id` INT, IN `usr_add` INT)   BEGIN
SELECT * FROM grpmember
WHERE group_id=g_id AND member_id=usr_add;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spCheckReadStatus` (IN `sunique_id` INT, IN `runique_id` INT)   BEGIN
SELECT * FROM messages WHERE incoming_msg_id=sunique_id AND 
                outgoing_msg_id=runique_id AND read_state = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spCheckTypeStatus` (IN `u_id` INT, IN `r_id` INT)   BEGIN
SELECT * FROM typeStatus WHERE sender_id=u_id AND receiver_id=r_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spCreateGroup` (IN `g_name` VARCHAR(255), IN `g_id` INT, IN `u_id` INT, IN `imgs_name` VARCHAR(255))   BEGIN
INSERT INTO grpadmin(group_name, group_id, admin_id, img_name) VALUES (g_name,g_id,u_id,imgs_name);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spDisplayUser` (IN `unique_id` INT, IN `outgoing_id` INT)   BEGIN
SELECT * FROM messages WHERE (incoming_msg_id=unique_id
                OR outgoing_msg_id=unique_id) AND (outgoing_msg_id=outgoing_id                OR incoming_msg_id=outgoing_id) ORDER BY msg_id DESC LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGroupAdmins` (IN `user_id` INT)   BEGIN
SELECT * FROM grpadmin WHERE group_id = user_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGroupChat` (IN `i_id` INT)   BEGIN
SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id WHERE incoming_msg_id=i_id ORDER BY msg_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGroupData` (IN `g_id` INT)   BEGIN
SELECT * FROM grpadmin WHERE group_id=g_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spInsertChat` (IN `i_id` INT, IN `o_id` INT, IN `message` VARCHAR(255), IN `r_count` INT)   BEGIN
INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, read_state)VALUES (i_id, o_id,message,r_count);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spInsertFileChat` (IN `i_id` INT, IN `o_id` INT, IN `message` VARCHAR(255), IN `f_iles` VARCHAR(255), IN `r_count` INT)   BEGIN
INSERT INTO messages(incoming_msg_id,outgoing_msg_id,msg,f_ile,read_state) VALUES(i_id,o_id,message,f_iles,r_count);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spInsertUser` (IN `ran_id` INT, IN `first_name` VARCHAR(255), IN `last_name` VARCHAR(255), IN `e_mail` VARCHAR(255), IN `pass` VARCHAR(255), IN `imgs` VARCHAR(255), IN `sts` VARCHAR(255))   BEGIN
INSERT INTO users (unique_id, fname, lname, email, password, img, status) VALUES (ran_id, first_name,last_name,e_mail,pass,imgs,sts);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spLastSeen` (IN `c_time` VARCHAR(255), IN `l_date` VARCHAR(255), IN `u_id` INT)   BEGIN
UPDATE users SET last_seenTime=c_time, last_seenDate=l_date WHERE unique_id=u_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spReadStatus` (IN `u_id` INT, IN `us_id` INT)   BEGIN
UPDATE messages SET read_state=0 WHERE incoming_msg_id=u_id AND outgoing_msg_id=us_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spSetStatus` (IN `c_time` VARCHAR(255), IN `l_id` INT)   BEGIN
UPDATE users SET status=c_time WHERE unique_id=l_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spSetTypeStatus` (IN `u_id` INT, IN `us_id` INT, IN `num` INT)   BEGIN
INSERT INTO typeStatus (sender_id, receiver_id, type_status)VALUES(u_id,us_id,num);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spShowGroup` (IN `unique_id` INT)   BEGIN
SELECT * FROM grpmember WHERE member_id=unique_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spShowUser` (IN `outgoing_id` INT)   BEGIN
SELECT * FROM users WHERE NOT unique_id = outgoing_id ORDER BY user_id DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTypeStatus` (IN `runique_id` INT, IN `sunique_id` INT)   BEGIN
SELECT * FROM typeStatus
WHERE sender_id=runique_id AND receiver_id=sunique_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spUpdateStatus` (IN `u_id` INT)   BEGIN
UPDATE users SET status = 'Active now' WHERE unique_id = u_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spUpdateTypeStatus` (IN `num` INT, IN `u_id` INT, IN `us_id` INT)   BEGIN
UPDATE typeStatus SET type_status=num WHERE
sender_id=u_id AND
receiver_id=us_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spUpdateUser` (IN `fsname` VARCHAR(255), IN `lsname` VARCHAR(255), IN `new_img_name` VARCHAR(255), IN `u_id` INT)   BEGIN
UPDATE users SET fname=fsname, lname=lsname, img=new_img_name WHERE unique_id=u_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spUsersDetails` (IN `u_id` INT)   BEGIN
SELECT * FROM users WHERE unique_id = u_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `grpadmin`
--

CREATE TABLE `grpadmin` (
  `g_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `img_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `grpmember`
--

CREATE TABLE `grpmember` (
  `grp_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(11) NOT NULL,
  `outgoing_msg_id` int(11) NOT NULL,
  `msg` varchar(1000) DEFAULT NULL,
  `f_ile` varchar(255) DEFAULT NULL,
  `read_state` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `typestatus`
--

CREATE TABLE `typestatus` (
  `ids` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `type_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `last_seenTime` time NOT NULL DEFAULT '00:00:00',
  `last_seenDate` date NOT NULL DEFAULT '2000-02-10'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grpadmin`
--
ALTER TABLE `grpadmin`
  ADD PRIMARY KEY (`g_id`);

--
-- Indexes for table `grpmember`
--
ALTER TABLE `grpmember`
  ADD PRIMARY KEY (`grp_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `typestatus`
--
ALTER TABLE `typestatus`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grpadmin`
--
ALTER TABLE `grpadmin`
  MODIFY `g_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grpmember`
--
ALTER TABLE `grpmember`
  MODIFY `grp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `typestatus`
--
ALTER TABLE `typestatus`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
