-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 25 Avril 2018 à 16:18
-- Version du serveur :  5.7.22-0ubuntu0.16.04.1
-- Version de PHP :  7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog_ecrivain`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `id_chapitre` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`id`, `date_creation`, `title`, `text`, `id_chapitre`, `slug`, `published`) VALUES
(18, '2018-03-30 09:12:22', 'chapitre 1', '<p><strong>Tu comprends, ce n\'est pas un simple sport car c\'est juste une question d\'awareness et &ccedil;a, c\'est tr&egrave;s dur, et, et, et... c\'est tr&egrave;s facile en m&ecirc;me temps. C\'est cette ann&eacute;e que j\'ai eu la r&eacute;v&eacute;lation !</strong></p>\r\n<p><strong>Tu vois, premi&egrave;rement, il faut se recr&eacute;er... pour recr&eacute;er... a better you puisque the final conclusion of the spirit is perfection Il y a un an, je t\'aurais parl&eacute; de mes muscles.</strong></p>\r\n<p><strong>Si je t\'emmerde, tu me le dis, je suis mon meilleur mod&egrave;le car le cycle du cosmos dans la vie... c\'est une grande roue et cette officialit&eacute; peut vraiment retarder ce qui devrait devenir... Et l&agrave;, vraiment, j\'essaie de tout coeur de donner la plus belle r&eacute;ponse de la terre !</strong></p>\r\n<p><strong>M&ecirc;me si on se ment, je ne suis pas un simple danseur car il y a de bonnes r&egrave;gles, de bonnes rules et finalement tout refaire depuis le d&eacute;but. Pour te dire comme on a beaucoup &agrave; apprendre sur la vie !</strong></p>\r\n<p><strong>You see, m&ecirc;me si on frime comme on appelle &ccedil;a en France... en v&eacute;rit&eacute;, la v&eacute;rit&eacute;, il n\'y a pas de v&eacute;rit&eacute; parce que spirituellement, on est tous ensemble, ok ? Et l&agrave;, vraiment, j\'essaie de tout coeur de donner la plus belle r&eacute;ponse de la terre !...</strong></p>', 1, 'chapitre-1-jcvd', 1),
(19, '2018-03-30 09:13:43', 'chapitre 2 jcvd', '<p><strong>Quand tu fais le calcul, je ne suis pas un simple danseur car il y a de bonnes r&egrave;gles, de bonnes rules et c\'est tr&egrave;s, tr&egrave;s beau d\'avoir son propre moi-m&ecirc;me ! Donc on n\'est jamais seul spirituellement !</strong></p>\r\n<p><strong>Tu comprends, premi&egrave;rement, on vit dans une r&eacute;alit&eacute; qu\'on a cr&eacute;&eacute;e et que j\'appelle illusion et je ne cherche pas ici &agrave; mettre un point ! Pour te dire comme on a beaucoup &agrave; apprendre sur la vie !</strong></p>\r\n<p><strong>Quand tu fais le calcul, tu vois au passage qu\'il n\'y a rien de concret car il faut se recr&eacute;er... pour recr&eacute;er... a better you et parfois c\'est bon parfois c\'est pas bon. Tu vas te dire : J\'aurais jamais cru que le karat&eacute; guy pouvait parler comme &ccedil;a !</strong></p>\r\n<p><strong>Tu vois, j\'ai vraiment une grande mission car l&agrave;, j\'ai un chien en ce moment &agrave; c&ocirc;t&eacute; de moi et je le caresse, puisque the final conclusion of the spirit is perfection Pour te dire comme on a beaucoup &agrave; apprendre sur la vie !</strong></p>\r\n<p><strong>Quand tu fais le calcul, si vraiment tu veux te rappeler des souvenirs de ton perroquet, on est tous capables de donner des informations &agrave; chacun parce que spirituellement, on est tous ensemble, ok ? Donc on n\'est jamais seul spirituellement !</strong></p>', 2, 'chapitre-2-jcvd', 1),
(20, '2018-03-30 09:15:27', 'chapitre 3 jcvd', '<p>Tu<strong> comprends, je ne suis pas un simple danseur car il faut se recr&eacute;er... pour recr&eacute;er... a better you et &ccedil;a, c\'est tr&egrave;s dur, et, et, et... c\'est tr&egrave;s facile en m&ecirc;me temps. &Ccedil;a respire le meuble de Provence, hein ?</strong></p>\r\n<p><strong>&Ccedil;a sounds good, si vraiment tu veux te rappeler des souvenirs de ton perroquet, entre penser et dire, il y a un monde de diff&eacute;rence et cela m&ecirc;me si les gens ne le savent pas ! Et tu as envie de le dire au monde entier, including yourself.</strong></p>\r\n<p><strong>Ah non attention, l&agrave; on voit qu\'on a beaucoup &agrave; travailler sur nous-m&ecirc;mes car c\'est juste une question d\'awareness et cette officialit&eacute; peut vraiment retarder ce qui devrait devenir... Et tu as envie de le dire au monde entier, including yourself.</strong></p>\r\n<p><strong>Oui alors &eacute;coute moi, si vraiment tu veux te rappeler des souvenirs de ton perroquet, entre penser et dire, il y a un monde de diff&eacute;rence et finalement tout refaire depuis le d&eacute;but. Et j\'ai toujours grandi parmi les chiens.</strong></p>\r\n<p><strong>Tu vois, premi&egrave;rement, il y a de bonnes r&egrave;gles, de bonnes rules et &ccedil;a, c\'est tr&egrave;s dur, et, et, et... c\'est tr&egrave;s facile en m&ecirc;me temps. Pour te dire comme on a beaucoup &agrave; apprendre sur la vie !</strong></p>', 3, 'chapitre-3-jcvd', 1),
(21, '2018-03-30 17:35:00', 'chapitre 4', '<p>chapitre 4</p>', 4, 'chapitre-4', 1),
(22, '2018-03-30 17:35:48', 'test de titre', '<p>iiiiiiiiiiiiii</p>', 5, 'slug-url', 1),
(26, '2018-04-02 12:12:08', 'chapitre de test des accents', '<p>&eacute;&nbsp; &egrave; &agrave; ^ &ugrave;&nbsp;</p>', 9, 'slug-test-bug', 1),
(28, '2018-04-03 16:42:40', 'test de titre nouvel essaie', '<p>test de texte modif</p>', 11, 'slug-loup', 1),
(32, '2018-04-25 09:48:37', 'retest', '<p><img src="https://static.wamiz.fr/uploads/chien%20dentier%20d.jpg" alt="" width="306" height="441" /><iframe src="//www.youtube.com/embed/CG9EGStW-nE" width="240" height="135"></iframe></p>\r\n<p>&nbsp;</p>\r\n<p>mlkjhgf</p>', 12, 'ffffffffffff', 1);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(70) NOT NULL,
  `content` longtext NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `approuved` tinyint(1) NOT NULL DEFAULT '0',
  `signalement` tinyint(1) DEFAULT '0',
  `id_chapitre` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `pseudo`, `content`, `date_creation`, `approuved`, `signalement`, `id_chapitre`) VALUES
(20, 'moi meme', 'hgjedhzehbcdzhkbdclkhbdlkbhzckhbzdclkhbcdlkjhbvdhbkjvldhblk', '2018-04-23 16:33:30', 0, 1, '2'),
(21, 'oooooo', 'hhhhhhhhhhhhhhhhhhh', '2018-04-23 16:48:28', 0, 1, '1'),
(22, 'yyyyyy', 'fffffffffffffff', '2018-04-23 16:50:57', 0, 0, '4'),
(23, 'oooooo', 'kkkkkkkkkkkkkkkkkkkkkkkk', '2018-04-23 16:53:11', 0, 0, '9'),
(24, 'bidule', 'commentaire test', '2018-04-24 08:32:23', 0, 1, '1'),
(25, 'test commentaire chap 12', 'blablabla', '2018-04-24 16:43:49', 0, 0, '12'),
(26, 'uuuu', 'mmmmmmm', '2018-04-24 16:50:19', 0, 1, '11'),
(27, 'eric judor', 'waaaaaaaa c&#39;est de toute beautÃ©Ã©Ã©Ã©Ã©Ã©Ã©Ã©', '2018-04-24 17:24:35', 0, 1, '3'),
(28, 'yop', 'huhuhu', '2018-04-24 21:10:56', 0, 0, '5'),
(29, 'juiop', 'jhytghuilo', '2018-04-24 21:11:32', 0, 0, '9'),
(30, 'jcvd', 'ghgjjjdjhccxhxnxnsns', '2018-04-25 13:26:04', 0, 1, '1');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(25) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_chapitre` (`id_chapitre`),
  ADD KEY `id_chapitre_2` (`id_chapitre`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_chapitre` (`id_chapitre`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
