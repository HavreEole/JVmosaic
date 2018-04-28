-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 23 avr. 2018 à 09:30
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mosaic`
--

-- --------------------------------------------------------

--
-- Structure de la table `mz_decrire`
--

DROP TABLE IF EXISTS `mz_decrire`;
CREATE TABLE IF NOT EXISTS `mz_decrire` (
  `numero` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero_PROJET` bigint(20) UNSIGNED NOT NULL,
  `numero_TAGS` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`numero`),
  KEY `FK_DECRIRE_numero_PROJET` (`numero_PROJET`),
  KEY `FK_DECRIRE_numero_TAGS` (`numero_TAGS`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mz_decrire`
--

INSERT INTO `mz_decrire` (`numero`, `numero_PROJET`, `numero_TAGS`) VALUES
(0, 9, 25),
(1, 8, 10),
(2, 7, 25),
(3, 6, 11),
(4, 5, 22),
(5, 4, 29),
(6, 3, 28),
(7, 2, 4),
(8, 1, 30),
(9, 0, 18),
(10, 9, 22),
(11, 8, 8),
(12, 7, 28),
(13, 6, 18),
(14, 5, 4),
(15, 4, 30),
(16, 3, 11),
(17, 2, 29),
(18, 1, 8),
(19, 0, 28),
(20, 9, 11);

-- --------------------------------------------------------

--
-- Structure de la table `mz_depeindre`
--

DROP TABLE IF EXISTS `mz_depeindre`;
CREATE TABLE IF NOT EXISTS `mz_depeindre` (
  `numero` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero_PERSONNE` bigint(20) UNSIGNED NOT NULL,
  `numero_TAGS` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`numero`),
  KEY `FK_DEPEINDRE_numero_PERSONNE` (`numero_PERSONNE`),
  KEY `FK_DEPEINDRE_numero_TAGS` (`numero_TAGS`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mz_depeindre`
--

INSERT INTO `mz_depeindre` (`numero`, `numero_PERSONNE`, `numero_TAGS`) VALUES
(0, 0, 6),
(1, 3, 6),
(2, 2, 1),
(3, 3, 1),
(4, 7, 15),
(5, 1, 12),
(6, 2, 4),
(7, 3, 14),
(8, 4, 1),
(9, 5, 7),
(10, 6, 2),
(11, 7, 3),
(12, 8, 4),
(13, 9, 5),
(14, 10, 8),
(15, 0, 9),
(16, 1, 10),
(17, 2, 11),
(18, 3, 12),
(19, 4, 13),
(20, 5, 14);

-- --------------------------------------------------------

--
-- Structure de la table `mz_personne`
--

DROP TABLE IF EXISTS `mz_personne`;
CREATE TABLE IF NOT EXISTS `mz_personne` (
  `numero` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` tinytext,
  `mdp` tinytext,
  `admin` tinyint(1) DEFAULT NULL,
  `ban` tinyint(1) DEFAULT NULL,
  `prenom` tinytext,
  `pseudo` tinytext,
  `nom` tinytext,
  `twitter` tinytext,
  `linkedin` tinytext,
  `website` tinytext,
  `description` text,
  `urlAvatar` tinytext,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mz_personne`
--

INSERT INTO `mz_personne` (`numero`, `email`, `mdp`, `admin`, `ban`, `prenom`, `pseudo`, `nom`, `twitter`, `linkedin`, `website`, `description`, `urlAvatar`) VALUES
(0, 'cami@vanille.com', 'vanille', 0, 0, 'Camille', '', 'Vanille', '@vanille', '', 'vanille.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ', 'img/avatars/0.jpg'),
(1, 'pinpin@lapin.com', 'lapin', 1, 0, 'Florïn', '', 'Zolli', '@pouet', 'pouet', 'pouet.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.', 'img/avatars/1.jpg'),
(2, 'dotydot@dot.com', 'dot', 0, 0, 'Blue', '', 'dotstar', '@blue', 'blue', 'blue.com', 'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 'img/avatars/2.jpg'),
(3, 'grrr@grrr.com', 'grrr', 0, 0, 'Teddy', '', 'Furbear', '@teddy', 'teddy', 'teddy.com', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness.', 'img/avatars/3.jpg'),
(4, 'picpicpic@ture.com', 'ture', 0, 0, 'Dan', '<strong>Pic</strong>', 'Greatcam', '@picpicpic', '', 'picpicpic.com', 'No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure.', 'img/avatars/4.jpg'),
(5, 'flyfly@flyfly.com', 'fly', 0, 0, 'Marty', '', 'Fly', '@fly', '', 'fly.com', 'To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it?', 'img/avatars/5.jpg'),
(6, 'potpotpot@pot.com', 'pot', 0, 0, 'Potter', '', 'Coolbus', '@potpotpot', '', 'potpotpot.com', 'But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?', 'img/avatars/6.jpg'),
(7, 'lalala@la.com', 'la', 0, 0, '', '', 'Lace', '@lalala', 'lalala', '', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.', 'img/avatars/7.jpg'),
(8, 'gregar@gargre.com', 'garden', 0, 0, 'Green', '<strong>Pretty</strong>', 'Garden', '', '', '', 'As our world becomes more and more connected, opportunities to work together to create new forms of art and utopian social systems become greater and greater. This interconnectedness is also overwhelming and shocking. We are increasingly exposed to each others’ suffering – suffering that has previously existed but was largely ignored.', 'img/avatars/8.jpg'),
(9, 'lili@cena.com', 'cena', 0, 0, 'Light', '', 'Cena', '@cena', '', '', 'In western culture all individuals are assumed to be self-interested; all shock is assumed to produce a fight-or-flight response; all narratives are assumed to require conflict; all villains are assumed to be evil; all social exchange, politics, and even the natural world are assumed to be driven by competition and won by domination. These are false, incomplete assumptions.', 'img/avatars/9.jpg'),
(10, 'grass@grass.com', 'grass', 0, 0, '', '<strong>Wide</strong>', 'Outdoor', '@outdoor', '', '', 'The stress theory of tend-and-befriend shows us that individuals are not purely self-interested and that shock does not only produce brutality or fear. We posit that the antidote to shock is not to dominate, not to disconnect, not to continue to ignore, but to take collective responsibility. The antidote for shock is to care.', 'img/avatars/10.jpg'),
(11, 'miam@miam.com', 'miam', 0, 0, 'Adorable', '<strong>Cute</strong>', 'Party', '', 'adorable', 'adorable.com', 'Care builds understanding, action, and connection. Care provides insight, healing and agency. Systems built on care are stronger than those built on non-consensual domination and fear. We seek mutually beneficial outcomes and utopian futures.', 'img/avatars/11.jpg'),
(12, 'o@cean.com', 'cean', 0, 0, 'Karin', '', 'Ocean', '', 'ocean', 'ocean.com', 'Video games are a natural place to explore and to prototype systems of care. We assert that video games have not only the ability but also the responsibility to explore care, systems of care, and utopian futures.', 'img/avatars/12.jpg'),
(13, 'chap@pie.com', 'pie', 0, 0, 'Chappie', '<strong>Mountain</strong>', 'Hat', '@chappie', '', '', 'We are not individual actors, our paths are not linear, and life is not a zero-sum game. Video games that provide fun through shock, fight-or-flight mechanics, conflict, power fantasies, dehumanized villains, zero-sum outcomes, and other expressions of non-consensual domination are incomplete expressions of what it is to be human.', 'img/avatars/13.jpg'),
(14, '__@__.com', 'blanche', 0, 0, 'Blanche', '<strong>White</strong>', 'Glasses', '', '', 'blanche.com', 'Carewave is a utopian movement of artworks that care. It is a movement of creators, audiences, and artworks taking responsibility for the power and influence we have as media creators and curators and collectively using this power to propagate visions of great worlds, where care is woven throughout our social structures and cultures.', 'img/avatars/14.jpg'),
(15, 'pink@brun.com', 'pink', 0, 0, 'Rose', '', 'Brown', '', 'pink', '', 'Carewave artworks are made in any medium: Carewave artworks are interactive or non-interactive or blur the lines between interactivity and non-interactivity. Carewave grew out of video games and has a foundation in connectedness, interactivity, and systems.', 'img/avatars/15.jpg'),
(16, 'point@glasses.com', 'dot', 0, 0, 'Dot', '', 'Curly', '', '', '', 'Utopia lies at the horizon. When I draw nearer by two steps, it retreats two steps. If I proceed ten steps forward, it swiftly slips ten steps ahead. No matter how far I go, I can never reach it. What, then, is the purpose of utopia? It is to cause us to advance. (Eduardo Galeano)', 'img/avatars/16.jpg'),
(17, 'denise@masque.com', 'mask', 0, 0, 'Venicia', '', 'Mask', '@venicia', 'venicia', 'venicia.com', 'This regulator is code--the software and hardware that make cyberspace as it is. This code, or architecture, sets the terms on which life in cyberspace is experienced. It determines how easy it is to protect privacy, or how easy it is to censor speech. It determines whether access to information is general or whether information is zoned. It affects who sees what, or what is monitored.', 'img/avatars/17.jpg'),
(18, 'large@town.com', 'big', 0, 0, 'Secret', '<strong>Big</strong>', 'City', '@bigcity', '', '', 'This regulation is changing. The code of cyberspace is changing. And as this code changes, the character of cyberspace will change as well. Cyberspace will change from a place that protects anonymity, free speech, and individual control, to a place that makes anonymity harder, speech less free, and individual control the province of individual experts only.', 'img/avatars/18.jpg'),
(19, 'jiji@ne.com', 'jean', 0, 0, 'Jean', '<strong>Jeanne</strong>', 'Graph', '', '', '', 'The basic code of the Internet implements a set of protocols called TCP/IP. These protocols enable the exchange of data among interconnected networks. This exchange occurs without the networks knowing the content of the data, or without any true idea of who in real life the sender of a given bit of data is. This code is neutral about the data, and ignorant about the user.', 'img/avatars/19.jpg'),
(20, 'lili@dev.com', 'dev', 0, 0, '', '<strong>Little</strong>', 'Dev', '', '', '', 'But no thought is more dangerous to the future of liberty in cyberspace than this faith in freedom guaranteed by the code. For the code is not fixed. The architecture of cyberspace is not given. Unregulability is a function of code, but the code can change. Other architectures can be layered onto the basic TCP/IP protocols, and these other architectures can make behavior on the Net fundamentally regulable. Commerce is building these other architectures; the government can help; the two together can transform the character of the Net. They can and they are.', 'img/avatars/20.jpg'),
(21, 'sourire@sourire.com', 'beard', 0, 0, 'Smile', '', 'Whitebeard', '@smile', '', 'smile.com', 'Thus whether the certification architecture that emerges protects privacy depends upon the choices of those who code. Their choices depend upon the incentives they face. If protecting privacy is not an incentive--if the market has not sufficiently demanded it and if law has not, either--then this code will not provide it.', 'img/avatars/21.jpg'),
(22, 'plage@plage.com', 'wave', 0, 0, 'Wave', '', 'Surfer', '@wave', '', '', 'Our choice is not between \"regulation\" and \"no regulation.\" The code regulates. It implements values, or not. It enables freedoms, or disables them. It protects privacy, or promotes monitoring. People choose how the code does these things. People write the code. Thus the choice is not whether people will decide how cyberspace regulates. People--coders--will. The only choice is whether we collectively will have a role in their choice--and thus in determining how these values regulate--or whether collectively we will allow the coders to select our values for us.', 'img/avatars/22.jpg'),
(23, 'ponponpon@pont.com', 'pont', 0, 0, 'Bridge', '<strong>Ocean</strong>', 'Mister', '', 'mister', '', '\"Le code détermine ce qui est possible ou impossible, qui a accès à quoi. Celles et ceux qui l\'écrivent ont la responsabilité de prendre les besoins des autres en compte.\" cf Lawrence Lessig, Code is Law', 'img/avatars/23.jpg'),
(24, 'ella@ella.com', 'ella', 0, 0, 'Two', '', 'Ombrella', '@ombrella', '', 'ombrella.com', '\"If you test your system on people who look like you and it works fine then you\'re never going to know that there\'s a problem\" Joy Buolamwini', 'img/avatars/24.jpg'),
(25, 'yumyum@coffee.com', 'yum', 0, 0, 'Chill', '', 'Coffee', '', '', '', 'There is growing concern that many of the algorithms that make decisions about our lives - from what we see on the internet to how likely we are to become victims or instigators of crime - are trained on data sets that do not include a diverse range of people.', 'img/avatars/25.jpg'),
(26, 'will@sky.com', 'will', 0, 0, 'Will', '<strong>Sky</strong>', 'Blondy', '', '', 'will.com', '\"I\'m now starting to think, are we testing to make sure these systems work on older people who aren\'t as well represented in the tech space? Are we also looking to make sure these systems work on people who might be overweight, because of some of the people who have reported it? It is definitely hitting a chord.\"', 'img/avatars/26.jpg'),
(27, 'ray@ure.com', 'ray', 0, 0, 'Ray', '<strong>Stripes</strong>', 'Yellow', '@ray', '', 'ray.com', 'In other words the concern has been that the bias, or skew, in decision-making will shift from things we recognise as human prejudice to things we no longer recognise and therefore cannot detect - because we will take the decision-making for granted.', 'img/avatars/27.jpg'),
(28, 'philippe', 'Phil-2016', 0, 0, 'Phillipe', '', 'Bouquet', '', 'forest', 'forest.com', 'Any technology that we create is going to reflect both our aspirations and our limitations', 'img/avatars/28.jpg'),
(29, 'sand@sand.com', 'sable', 0, 0, 'Sand', '', 'Marine', '', '', '', 'If we are limited when it comes to being inclusive that\'s going to be reflected in the robots we develop or the tech that\'s incorporated within the robots.', 'img/avatars/29.jpg'),
(30, 'lili@manager.com', 'mana', 0, 0, 'Lila', '', 'Manager', '', '', '', 'Ms Buolamwini says she is hopeful that the situation will improve if people are more aware of the potential problems.', 'img/avatars/30.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `mz_projet`
--

DROP TABLE IF EXISTS `mz_projet`;
CREATE TABLE IF NOT EXISTS `mz_projet` (
  `numero` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mdp` tinytext,
  `nom` tinytext,
  `studio` tinytext,
  `description` text,
  `dateSortie` date DEFAULT NULL,
  `website` tinytext,
  `urlVisuel` tinytext,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mz_projet`
--

INSERT INTO `mz_projet` (`numero`, `mdp`, `nom`, `studio`, `description`, `dateSortie`, `website`, `urlVisuel`) VALUES
(0, 'sjfpelsifn', 'LOL', 'Studio Lol', 'Un jeu où on rigole énormément.', '2001-01-01', 'lololol.com', 'img/visuels/0.jpg'),
(1, 'dfgfgdfggg', 'Libraire', 'Raplapla', 'Vous travaillez dans une bibliothèque.', '2001-01-01', 'pouet.com', 'img/visuels/1.jpg'),
(2, 'eqzeqzezee', 'Lapins Attaque', '5 Jours', 'C\'est peut-être un piège avec des bruits bizarres...', '2001-01-01', 'nini.com', 'img/visuels/2.jpg'),
(3, 'poihjjfgff', 'Bêtes Apparat', 'Boulanger', 'C\'est pas gagné mais c\'est sympa d\'essayer !', '2001-01-01', 'gagaga.com', 'img/visuels/3.jpg'),
(4, 'bnrqseezrr', 'Nombres on fire', 'Pierre', 'Attention, il ne faut pas partir en mission en solitaire.', '2001-01-01', 'toto.com', 'img/visuels/4.jpg'),
(5, 'yuityrdfff', 'Hôtel Castor', 'Heures', 'Comme c\'est joli il y a des rondins et c\'est gentil !', '2001-01-01', 'tutu.com', 'img/visuels/5.jpg'),
(6, 'azeedxdfgg', 'Salopette Nocturne', 'Vampire', 'La spéléologie pour les chauve-souris.', '2001-01-01', 'yop.com', 'img/visuels/6.jpg'),
(7, 'dfghjjghyy', 'Lumière Bonsoir', 'Repos', 'C\'est très tranquille.', '2001-01-01', 'hiphip.com', 'img/visuels/7.jpg'),
(8, 'zezeddvfgg', 'Poisson ici famille', 'L\'Equipe', 'Un jeu avec des familles de poissons. Des fois ils ont des points communs, mais faut pas le dire.', '2001-01-01', 'plop.com', 'img/visuels/8.jpg'),
(9, 'mlmouigfgg', 'Patience', 'Reflexion', 'Ca s\'appelle Patience mais en fait c\'est vachement rapide, c\'est un concept.', '2001-01-01', 'krr.com', 'img/visuels/9.jpg'),
(10, 'sjfpelsifn', 'LOL', 'Studio Lol', 'Un jeu où on rigole énormément.', '2001-01-01', 'lololol.com', 'img/visuels/0.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `mz_tags`
--

DROP TABLE IF EXISTS `mz_tags`;
CREATE TABLE IF NOT EXISTS `mz_tags` (
  `numero` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` tinytext,
  `nbUsages` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mz_tags`
--

INSERT INTO `mz_tags` (`numero`, `nom`, `nbUsages`) VALUES
(0, 'Freelance', 0),
(1, 'Journalisme', 3),
(2, 'Narrative Design', 1),
(3, 'Community Management', 1),
(4, 'Unity', 7),
(5, 'Management', 1),
(6, 'Graphisme', 2),
(7, 'Game Design', 1),
(8, 'Web', 6),
(9, 'Level Design', 1),
(10, '3D', 3),
(11, 'Game Jam', 7),
(12, 'Lead', 2),
(13, 'Indie', 1),
(14, 'Need Job', 2),
(15, 'Illustration', 1),
(16, 'Concept Art', 0),
(17, 'Chroniques', 0),
(18, 'Youtube', 4),
(19, 'Streaming', 0),
(20, 'Recherche', 0),
(21, 'Enseignement', 0),
(22, 'Musique', 3),
(23, 'Composing', 0),
(24, 'Sound Design', 0),
(25, 'Animation', 4),
(26, 'Expat', 0),
(27, 'Tool Dev', 0),
(28, '2D', 7),
(29, 'Indie', 5),
(30, 'Developpement', 5);

-- --------------------------------------------------------

--
-- Structure de la table `mz_travailler`
--

DROP TABLE IF EXISTS `mz_travailler`;
CREATE TABLE IF NOT EXISTS `mz_travailler` (
  `numero` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero_PERSONNE` bigint(20) UNSIGNED NOT NULL,
  `numero_PROJET` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`numero`),
  KEY `FK_TRAVAILLER_numero_PERSONNE` (`numero_PERSONNE`),
  KEY `FK_TRAVAILLER_numero_PROJET` (`numero_PROJET`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mz_travailler`
--

INSERT INTO `mz_travailler` (`numero`, `numero_PERSONNE`, `numero_PROJET`) VALUES
(1, 5, 2),
(2, 7, 4),
(3, 12, 6),
(4, 5, 8),
(6, 7, 2),
(7, 2, 4),
(8, 11, 6),
(9, 0, 8),
(10, 19, 1),
(11, 8, 3),
(12, 17, 5),
(13, 6, 7),
(14, 2, 9),
(15, 4, 1),
(16, 3, 3),
(17, 2, 5),
(18, 1, 7),
(19, 0, 9),
(24, 4, 0),
(25, 9, 0),
(26, 14, 2),
(27, 15, 1),
(28, 16, 2),
(29, 17, 3);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `mz_decrire`
--
ALTER TABLE `mz_decrire`
  ADD CONSTRAINT `FK_DECRIRE_numero_PROJET` FOREIGN KEY (`numero_PROJET`) REFERENCES `mz_projet` (`numero`),
  ADD CONSTRAINT `FK_DECRIRE_numero_TAGS` FOREIGN KEY (`numero_TAGS`) REFERENCES `mz_tags` (`numero`);

--
-- Contraintes pour la table `mz_depeindre`
--
ALTER TABLE `mz_depeindre`
  ADD CONSTRAINT `FK_DEPEINDRE_numero_PERSONNE` FOREIGN KEY (`numero_PERSONNE`) REFERENCES `mz_personne` (`numero`),
  ADD CONSTRAINT `FK_DEPEINDRE_numero_TAGS` FOREIGN KEY (`numero_TAGS`) REFERENCES `mz_tags` (`numero`);

--
-- Contraintes pour la table `mz_travailler`
--
ALTER TABLE `mz_travailler`
  ADD CONSTRAINT `FK_TRAVAILLER_numero_PERSONNE` FOREIGN KEY (`numero_PERSONNE`) REFERENCES `mz_personne` (`numero`),
  ADD CONSTRAINT `FK_TRAVAILLER_numero_PROJET` FOREIGN KEY (`numero_PROJET`) REFERENCES `mz_projet` (`numero`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
