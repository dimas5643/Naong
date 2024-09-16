

CREATE TABLE `banners` (
  `id_banner` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `arquivo` varchar(45) NOT NULL,
  `dtinicial` datetime NOT NULL,
  `dtfinal` datetime NOT NULL,
  PRIMARY KEY (`id_banner`)
);

CREATE TABLE `banners` (
  `id_banner` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `arquivo` varchar(45) NOT NULL,
  `dtinicial` datetime NOT NULL,
  `dtfinal` datetime NOT NULL,
  PRIMARY KEY (`id_banner`)
);

CREATE TABLE `departamentos` (
  `id_departamento` int(11) NOT NULL AUTO_INCREMENT,
  `nome_departamento` varchar(45) DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_departamento`)
) ;

CREATE TABLE `doadores` (
  `id_doador` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `cpf_cnpj` varchar(45) NOT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `cep` varchar(45) DEFAULT NULL,
  `pais` varchar(45) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `senha` varchar(200) DEFAULT NULL,
  `nascimento` date DEFAULT NULL,
  `cadastro` datetime DEFAULT NULL,
  `endereco` varchar(45) DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_doador`,`email`,`cpf_cnpj`)
);

CREATE TABLE `necessidades` (
  `id_necessidade` int(11) NOT NULL AUTO_INCREMENT,
  `id_ong` int(11) DEFAULT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  `quantidade` float DEFAULT NULL,
  PRIMARY KEY (`id_necessidade`),
  KEY `fk_necessidade_ong_idx` (`id_ong`),
  KEY `fk_necessidade_departamento_idx` (`id_departamento`),
  CONSTRAINT `fk_necessidade_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_necessidade_ong` FOREIGN KEY (`id_ong`) REFERENCES `ongs` (`id_ong`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE `ongs` (
  `id_ong` int(11) NOT NULL AUTO_INCREMENT,
  `cnpj` varchar(45) NOT NULL,
  `razao_social` varchar(45) DEFAULT NULL,
  `nome_fantasia` varchar(45) DEFAULT NULL,
  `endereco` varchar(45) DEFAULT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `cep` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `pais` varchar(45) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  `senha` varchar(200) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `area_atuacao` varchar(255) DEFAULT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `site` varchar(60) DEFAULT NULL,
  `instagram` varchar(45) DEFAULT NULL,
  `facebook` varchar(45) NOT NULL,
  PRIMARY KEY (`id_ong`,`cnpj`,`email`),
  KEY `fk_id_departamento_idx` (`id_departamento`),
  CONSTRAINT `fk_id_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`)
);

CREATE TABLE `pontos_coleta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ong` int(11) DEFAULT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `rua` varchar(45) DEFAULT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `pais` varchar(45) DEFAULT NULL,
  `cep` varchar(45) DEFAULT NULL,
  `numero_endereco` varchar(45) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ong_coleta_idx` (`ong`),
  CONSTRAINT `ong_coleta` FOREIGN KEY (`ong`) REFERENCES `ongs` (`id_ong`)
);

CREATE TABLE `publicacao_pontos_coleta` (
  `id_pontos_coleta` int(11) NOT NULL,
  `id_publicacao` int(11) NOT NULL,
  KEY `fk_pontos_coleta_idx` (`id_pontos_coleta`),
  KEY `fk_publicacao_idx` (`id_publicacao`),
  CONSTRAINT `fk_pontos_coleta` FOREIGN KEY (`id_pontos_coleta`) REFERENCES `pontos_coleta` (`id`),
  CONSTRAINT `fk_publicacao` FOREIGN KEY (`id_publicacao`) REFERENCES `publicacoes` (`id_publicacoes`)
);

CREATE TABLE `publicacoes` (
  `id_publicacoes` int(11) NOT NULL AUTO_INCREMENT,
  `id_ong` int(11) DEFAULT NULL,
  `titulo` varchar(45) DEFAULT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `dtpublicacao` datetime DEFAULT NULL,
  `arquivo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_publicacoes`)
);

CREATE TABLE `registro_doacoes` (
  `id_registro` int(11) NOT NULL AUTO_INCREMENT,
  `id_doador` int(11) DEFAULT NULL,
  `id_ong` int(11) DEFAULT NULL,
  `doacao` varchar(45) DEFAULT NULL,
  `data_doacao` datetime DEFAULT NULL,
  `valor` float DEFAULT NULL,
  PRIMARY KEY (`id_registro`),
  KEY `idx_registro_ong` (`id_doador`),
  KEY `fk_registro_ong_idx` (`id_ong`),
  CONSTRAINT `fk_registro_doador` FOREIGN KEY (`id_doador`) REFERENCES `doadores` (`id_doador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_ong` FOREIGN KEY (`id_ong`) REFERENCES `ongs` (`id_ong`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE `administradores` (
  `id_administradores` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_administradores`)
);