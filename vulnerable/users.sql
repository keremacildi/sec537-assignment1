USE cs437project;

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

LOCK TABLES `users` WRITE;
INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin123', 'admin'),
(2, 'testuser', 'test123', 'user'),
(3, 'dummy', 'dummy123', 'user'),
(4, 'guest', 'guest123', 'user'),
(5, 'admin_master', 'adminpass1', 'admin'),
(6, 'superadmin', 'adminpass2', 'admin'),
(7, 'root_admin', 'adminpass3', 'admin'),
(8, 'john_doe', 'password123', 'user'),
(9, 'jane_smith', 'pass456', 'user'),
(10, 'alice_wonder', 'alice2024', 'user'),
(11, 'bob_builder', 'bobsecure', 'user'),
(12, 'charlie_brown', 'charlie789', 'user'),
(13, 'daisy_duke', 'daisy2023', 'user'),
(14, 'edward_snow', 'edward321', 'user'),
(15, 'frank_castle', 'punisher123', 'user'),
(16, 'grace_hopper', 'grace2024', 'user'),
(17, 'harry_potter', 'magic123', 'user'),
(18, 'isabella_ross', 'bella2023', 'user'),
(19, 'jack_sparrow', 'captain123', 'user'),
(20, 'karen_miller', 'karen789', 'user'),
(21, 'leo_dicaprio', 'leo2024', 'user'),
(22, 'mike_tyson', 'boxing2024', 'user'),
(23, 'natalie_port', 'natalie123', 'user'),
(24, 'oliver_twist', 'oliver2024', 'user');
UNLOCK TABLES;
