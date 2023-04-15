
DROP TABLE IF EXISTS `reminders`;
CREATE TABLE IF NOT EXISTS `reminders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '0',
  `forDateTime` datetime NOT NULL,
  `createdAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_reminders_users` (`userId`)
);

--
-- Dumping data for table `reminders`
--

INSERT INTO `reminders` (`id`, `userId`, `title`, `description`, `isActive`, `forDateTime`, `createdAt`) VALUES
(6, 3, 'Birthday reminder', 'Birthday of my friend Arunangshu Biswas', 1, '1998-03-11 00:00:00', '2023-04-02 19:20:00'),
(5, 2, 'Test reminder', 'Birthday', 1, '1998-03-11 00:00:00', '2023-04-02 19:20:00'),
(7, 3, 'Amber monitoring', 'Check saved messages once and then go for amber monitoring', 1, '2023-04-03 10:00:00', '2023-04-02 22:51:00'),
(8, 3, 'Inactive reminder', 'In my mail i should not reveive this email', 0, '2023-04-04 10:00:00', '2023-04-02 22:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `roleName` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
);

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `roleName`) VALUES
(1, 'ADMIN'),
(2, 'SIMPLE_USER');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `passwordHash` text NOT NULL,
  `name` varchar(250) NOT NULL,
  `roleId` smallint NOT NULL DEFAULT '2' COMMENT 'role value 2 means normal user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_username` (`username`),
  KEY `FK_user_role` (`roleId`)
);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `passwordHash`, `name`, `roleId`) VALUES
(2, 'arunangshu.biswas.x@gmail.com', '$2y$10$.qKAnIyGh/JAQcseuYGeZeXCYIfejceDr/DBXNlYTLV.7zZTCkT4e', 'Arunangshu Biswas', 1),
(3, 'arunangshu.biswas03@gmail.com', '$2y$10$OBJOEMB4Hh5/nawoJunhmuTDiQw1TNMianTt/5dtewl7MVXJmkj2a', 'Arunangshu Biswas', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
