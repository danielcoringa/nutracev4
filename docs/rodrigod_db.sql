/*
Navicat MySQL Data Transfer

Source Server         : rodrigodaniel.com.br
Source Server Version : 50172
Source Host           : rodrigodaniel.com.br:3306
Source Database       : rodrigod_db

Target Server Type    : MYSQL
Target Server Version : 50172
File Encoding         : 65001

Date: 2014-01-27 11:09:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tab_conf_artigo`
-- ----------------------------
DROP TABLE IF EXISTS `tab_conf_artigo`;
CREATE TABLE `tab_conf_artigo` (
  `cod_conf_artigo` bigint(20) NOT NULL AUTO_INCREMENT,
  `cod_artigo` bigint(20) NOT NULL,
  `bg_color` varchar(200) DEFAULT NULL,
  `bg_image` varchar(200) DEFAULT NULL,
  `bg_repeat` varchar(200) DEFAULT NULL,
  `bg_size` varchar(200) DEFAULT NULL,
  `bg_position` varchar(200) DEFAULT NULL,
  `ind_status` char(1) NOT NULL DEFAULT 'A',
  `sidebar` varchar(200) NOT NULL DEFAULT 'left',
  `bgcolor_meta` varchar(200) NOT NULL DEFAULT '#1e73be',
  `bg_pattern` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`cod_conf_artigo`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tab_conf_artigo
-- ----------------------------
INSERT INTO `tab_conf_artigo` VALUES ('1', '1', 'rgba(255,255,255,1)', '', 'no-repeat', 'auto', 'left', 'A', 'left', '#1e73be', '');
INSERT INTO `tab_conf_artigo` VALUES ('2', '2', 'rgba(255,255,255,1)', 'media/2014/01/0_96773700_1390655973.', 'no-repeat', 'auto', 'left', 'A', 'left', '#1e73be', '');
INSERT INTO `tab_conf_artigo` VALUES ('3', '3', 'rgba(255,255,255,1)', '', 'no-repeat', 'auto', 'left', 'A', 'left', '#1e73be', '');
INSERT INTO `tab_conf_artigo` VALUES ('13', '13', 'rgba(255,255,255,1)', '', 'no-repeat', 'auto', 'left', 'A', 'left', '#1e73be', '');
INSERT INTO `tab_conf_artigo` VALUES ('14', '14', 'rgba(255,255,255,1)', '', 'no-repeat', 'auto', 'left', 'A', 'left', '#1e73be', '');

-- ----------------------------
-- Table structure for `tab_conf_geral`
-- ----------------------------
DROP TABLE IF EXISTS `tab_conf_geral`;
CREATE TABLE `tab_conf_geral` (
  `cod_conf_geral` bigint(20) NOT NULL AUTO_INCREMENT,
  `img_upload` char(1) NOT NULL DEFAULT 'A',
  `img_thumbnail_w` decimal(10,1) NOT NULL,
  `ind_img_thumbnail` char(1) NOT NULL DEFAULT 'A',
  `img_list_w` decimal(10,1) NOT NULL,
  `ind_img_list` char(1) NOT NULL DEFAULT 'A',
  `img_medium_w` decimal(10,1) NOT NULL,
  `ind_img_medium` char(1) NOT NULL DEFAULT 'A',
  `img_big_w` decimal(10,1) NOT NULL,
  `ind_img_big` char(1) NOT NULL DEFAULT 'A',
  `ind_img_large` char(1) NOT NULL DEFAULT 'A',
  `img_large_w` decimal(10,1) NOT NULL,
  `ind_img_small` char(1) NOT NULL DEFAULT 'A',
  `img_small_w` decimal(10,1) NOT NULL,
  `ind_img_flickr` char(1) NOT NULL DEFAULT 'I',
  `ind_img_google` char(1) NOT NULL DEFAULT 'I',
  PRIMARY KEY (`cod_conf_geral`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tab_conf_geral
-- ----------------------------
INSERT INTO `tab_conf_geral` VALUES ('1', 'A', '160.0', 'A', '40.0', 'A', '800.0', 'A', '1920.0', 'I', 'I', '1024.0', 'I', '640.0', 'A', 'A');

-- ----------------------------
-- Table structure for `tab_web_artigo`
-- ----------------------------
DROP TABLE IF EXISTS `tab_web_artigo`;
CREATE TABLE `tab_web_artigo` (
  `cod_artigo` bigint(20) NOT NULL AUTO_INCREMENT,
  `cod_autor` bigint(20) NOT NULL,
  `nom_artigo` varchar(200) NOT NULL,
  `tipo_artigo` varchar(200) DEFAULT NULL,
  `tipo_privacidade` varchar(200) DEFAULT NULL,
  `dta_artigo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dta_publicacao` timestamp NULL DEFAULT NULL,
  `dta_expiracao` timestamp NULL DEFAULT NULL,
  `des_artigo` text NOT NULL,
  `tag_artigo` text,
  `num_views` int(11) NOT NULL DEFAULT '0',
  `num_likes` int(11) NOT NULL DEFAULT '0',
  `ind_review` char(1) DEFAULT 'N',
  `ind_status` char(1) DEFAULT 'A',
  PRIMARY KEY (`cod_artigo`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tab_web_artigo
-- ----------------------------
INSERT INTO `tab_web_artigo` VALUES ('1', '0', 'Teste de Galeria', 'gallery', null, '2014-01-25 11:09:48', '2014-01-25 11:03:00', '0000-00-00 00:00:00', '<p>Testando a galeria de fotos</p>\r\n', null, '5', '0', null, 'A');
INSERT INTO `tab_web_artigo` VALUES ('2', '0', 'Papeis de Parede', 'gallery', null, '2014-01-25 11:22:16', '2014-01-25 11:18:00', '0000-00-00 00:00:00', '<p>Alguns pap&eacute;is de parede selecionados de jogos famosos em alta resolu&ccedil;&atilde;o para o seu desktop.</p>\r\n', null, '76', '0', null, 'A');
INSERT INTO `tab_web_artigo` VALUES ('3', '0', 'The Walking Dead', 'gallery', null, '2014-01-25 23:46:43', '2014-01-25 23:45:00', '0000-00-00 00:00:00', '', null, '3', '0', null, 'A');
INSERT INTO `tab_web_artigo` VALUES ('13', '0', 'Testando Artigo de Audio', 'audio', null, '2014-01-27 03:27:24', '2014-01-27 03:13:00', '0000-00-00 00:00:00', '<p>Testando Artigo de Audio com SoundCloud.<iframe frameborder=\"no\" height=\"166\" scrolling=\"no\" src=\"https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/130065778&amp;color=ff6600&amp;auto_play=false&amp;show_artwork=true\" width=\"100%\"></iframe></p>\r\n', null, '1', '0', null, 'A');
INSERT INTO `tab_web_artigo` VALUES ('14', '0', 'Artigo de Audio', 'audio', null, '2014-01-27 04:18:38', '2014-01-27 04:17:00', '0000-00-00 00:00:00', '<p>Testando<iframe frameborder=\"no\" height=\"166\" scrolling=\"no\" src=\"https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/130063100&amp;color=ff6600&amp;auto_play=false&amp;show_artwork=true\" width=\"100%\"></iframe></p>\r\n', null, '1', '0', null, 'A');

-- ----------------------------
-- Table structure for `tab_web_audio`
-- ----------------------------
DROP TABLE IF EXISTS `tab_web_audio`;
CREATE TABLE `tab_web_audio` (
  `cod_audio` bigint(20) NOT NULL AUTO_INCREMENT,
  `cod_artigo` bigint(20) NOT NULL,
  `nom_musica` varchar(200) DEFAULT NULL,
  `id_musica` varchar(200) NOT NULL,
  `ind_status` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_audio`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tab_web_audio
-- ----------------------------
INSERT INTO `tab_web_audio` VALUES ('1', '14', 'Sweet Child O\'Mine Remix', '130063100', 'A');

-- ----------------------------
-- Table structure for `tab_web_autor`
-- ----------------------------
DROP TABLE IF EXISTS `tab_web_autor`;
CREATE TABLE `tab_web_autor` (
  `cod_autor` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom_autor` varchar(200) NOT NULL,
  `ind_status` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_autor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tab_web_autor
-- ----------------------------

-- ----------------------------
-- Table structure for `tab_web_categoria`
-- ----------------------------
DROP TABLE IF EXISTS `tab_web_categoria`;
CREATE TABLE `tab_web_categoria` (
  `cod_categoria` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom_categoria` varchar(200) NOT NULL,
  `des_categoria` text,
  `ind_status` char(1) NOT NULL DEFAULT 'A' COMMENT 'A,I,E',
  PRIMARY KEY (`cod_categoria`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tab_web_categoria
-- ----------------------------
INSERT INTO `tab_web_categoria` VALUES ('1', 'Games', '<p>Categoria relacionada ao conte&uacute;do dos jogos para todos os tipos de plataforma.</p>\n', 'A');
INSERT INTO `tab_web_categoria` VALUES ('2', 'Teste', null, 'A');
INSERT INTO `tab_web_categoria` VALUES ('3', 'Outro', null, 'A');
INSERT INTO `tab_web_categoria` VALUES ('4', 'Programação', null, 'A');
INSERT INTO `tab_web_categoria` VALUES ('5', 'Apple', null, 'A');
INSERT INTO `tab_web_categoria` VALUES ('6', 'Android', null, 'A');
INSERT INTO `tab_web_categoria` VALUES ('7', 'Séries', null, 'A');
INSERT INTO `tab_web_categoria` VALUES ('8', 'Piada', null, 'A');
INSERT INTO `tab_web_categoria` VALUES ('9', 'OPA', null, 'A');
INSERT INTO `tab_web_categoria` VALUES ('10', 'Firefox', null, 'A');
INSERT INTO `tab_web_categoria` VALUES ('11', 'Legal', null, 'A');
INSERT INTO `tab_web_categoria` VALUES ('12', 'Mais um', null, 'A');

-- ----------------------------
-- Table structure for `tab_web_categoria_artigo`
-- ----------------------------
DROP TABLE IF EXISTS `tab_web_categoria_artigo`;
CREATE TABLE `tab_web_categoria_artigo` (
  `cod_categoria_artigo` bigint(20) NOT NULL AUTO_INCREMENT,
  `cod_categoria` bigint(20) NOT NULL,
  `cod_artigo` bigint(20) NOT NULL,
  `ind_status` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_categoria_artigo`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tab_web_categoria_artigo
-- ----------------------------
INSERT INTO `tab_web_categoria_artigo` VALUES ('1', '6', '1', 'A');
INSERT INTO `tab_web_categoria_artigo` VALUES ('2', '1', '2', 'A');
INSERT INTO `tab_web_categoria_artigo` VALUES ('3', '10', '3', 'A');
INSERT INTO `tab_web_categoria_artigo` VALUES ('5', '1', '13', 'A');
INSERT INTO `tab_web_categoria_artigo` VALUES ('6', '9', '13', 'A');
INSERT INTO `tab_web_categoria_artigo` VALUES ('7', '10', '14', 'A');

-- ----------------------------
-- Table structure for `tab_web_galeria`
-- ----------------------------
DROP TABLE IF EXISTS `tab_web_galeria`;
CREATE TABLE `tab_web_galeria` (
  `cod_galeria` bigint(20) NOT NULL AUTO_INCREMENT,
  `cod_artigo` bigint(20) DEFAULT NULL,
  `nom_imagem` varchar(200) NOT NULL,
  `ext_imagem` varchar(200) NOT NULL,
  `des_imagem` varchar(200) DEFAULT NULL,
  `nom_pasta` varchar(200) NOT NULL,
  `ind_status` char(1) NOT NULL DEFAULT 'A',
  `num_ordem` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cod_galeria`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tab_web_galeria
-- ----------------------------
INSERT INTO `tab_web_galeria` VALUES ('1', '1', '0_51820100_1390655057', 'jpg', 'Foto dela', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('2', '1', '0_02414400_1390655057', 'jpg', 'Ela na foto', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('3', '1', '0_53837100_1390655057', 'jpg', 'Ele na foto', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('4', '2', '0_32262200_1390656012', 'jpg', 'Velvet Assassin', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('5', '2', '0_34624000_1390656009', 'jpg', 'Vengence', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('6', '2', '0_25917300_1390656011', 'jpg', 'Assassin Creed', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('7', '2', '0_19985900_1390656011', 'jpg', 'Blood Sweet Blood', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('8', '2', '0_80924000_1390656013', 'jpg', 'Não faço ideia', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('9', '2', '0_37579400_1390656013', 'jpg', 'Acho que é o Batman', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('10', '2', '0_48006300_1390656016', 'jpg', 'Need for Speed', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('11', '2', '0_79546500_1390656021', 'jpg', 'Driver', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('12', '2', '0_89878500_1390656024', 'jpg', 'Speed Racer', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('13', '2', '0_93792800_1390656027', 'jpg', 'Resident Evil', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('14', '2', '0_99486800_1390656029', 'jpg', 'Jaspion', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('15', '2', '0_26399800_1390656030', 'jpg', 'X-man', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('16', '2', '0_05776700_1390656027', 'jpg', 'Godzila', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('17', '2', '0_60844500_1390656029', 'jpg', 'Star Wars', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('18', '3', '0_64529000_1390700777', 'jpg', 'episódioepp', '/gallery/2014/01/', 'A', '0');
INSERT INTO `tab_web_galeria` VALUES ('19', '3', '0_25082500_1390700786', 'jpg', 'celular', '/gallery/2014/01/', 'A', '0');

-- ----------------------------
-- Table structure for `tab_web_imagem`
-- ----------------------------
DROP TABLE IF EXISTS `tab_web_imagem`;
CREATE TABLE `tab_web_imagem` (
  `cod_imagem` bigint(20) NOT NULL AUTO_INCREMENT,
  `cod_artigo` bigint(20) NOT NULL,
  `img_name` varchar(200) NOT NULL,
  `img_tipo` varchar(20) NOT NULL,
  `img_thumb` varchar(200) DEFAULT NULL,
  `ind_status` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_imagem`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tab_web_imagem
-- ----------------------------

-- ----------------------------
-- Table structure for `tab_web_lixeira`
-- ----------------------------
DROP TABLE IF EXISTS `tab_web_lixeira`;
CREATE TABLE `tab_web_lixeira` (
  `cod_lixeira` bigint(11) NOT NULL AUTO_INCREMENT,
  `nom_tabela` varchar(200) NOT NULL,
  `campo_tabela` varchar(200) NOT NULL,
  `cod_campo` bigint(11) NOT NULL,
  `dta_exclusao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cod_lixeira`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tab_web_lixeira
-- ----------------------------
INSERT INTO `tab_web_lixeira` VALUES ('1', 'tab_web_artigo', 'cod_artigo', '2', '2014-01-20 13:18:03');
INSERT INTO `tab_web_lixeira` VALUES ('2', 'tab_web_artigo', 'cod_artigo', '3', '2014-01-20 13:18:03');
INSERT INTO `tab_web_lixeira` VALUES ('3', 'tab_web_artigo', 'cod_artigo', '4', '2014-01-20 13:18:03');

-- ----------------------------
-- Table structure for `tab_web_review`
-- ----------------------------
DROP TABLE IF EXISTS `tab_web_review`;
CREATE TABLE `tab_web_review` (
  `cod_review` bigint(20) NOT NULL AUTO_INCREMENT,
  `cod_artigo` bigint(20) NOT NULL,
  `nom_review` varchar(200) NOT NULL DEFAULT 'Pontuação',
  `des_review` text,
  `star_color` varchar(200) DEFAULT NULL,
  `score_color` varchar(200) DEFAULT NULL,
  `criterio_one` varchar(200) DEFAULT NULL,
  `score_one` decimal(10,1) DEFAULT NULL,
  `criterio_two` varchar(200) DEFAULT NULL,
  `score_two` decimal(10,1) DEFAULT NULL,
  `criterio_three` varchar(200) DEFAULT NULL,
  `score_three` decimal(10,1) DEFAULT NULL,
  `criterio_four` varchar(200) DEFAULT NULL,
  `score_four` decimal(10,1) DEFAULT NULL,
  `criterio_five` varchar(200) DEFAULT NULL,
  `total_score` decimal(10,1) DEFAULT NULL,
  `score_five` decimal(10,1) DEFAULT NULL,
  `ind_status` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_review`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tab_web_review
-- ----------------------------

-- ----------------------------
-- Table structure for `tab_web_video`
-- ----------------------------
DROP TABLE IF EXISTS `tab_web_video`;
CREATE TABLE `tab_web_video` (
  `cod_video` bigint(20) NOT NULL AUTO_INCREMENT,
  `cod_artigo` bigint(20) NOT NULL,
  `id_video` varchar(200) NOT NULL,
  `id_file` varchar(200) NOT NULL,
  `tipo_video` varchar(200) NOT NULL,
  `ind_status` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cod_video`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tab_web_video
-- ----------------------------
