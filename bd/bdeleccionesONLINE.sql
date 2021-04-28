/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.3.28-MariaDB-cll-lve : Database - jattugco_candidatos
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`jattugco_candidatos` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `jattugco_candidatos`;

/*Table structure for table `candidatodetalle` */

DROP TABLE IF EXISTS `candidatodetalle`;

CREATE TABLE `candidatodetalle` (
  `codDetalle` int(11) NOT NULL,
  `ci` int(11) DEFAULT NULL,
  `formacAca` tinytext DEFAULT NULL,
  `formacProf` tinytext DEFAULT NULL,
  `experLab` tinytext DEFAULT NULL,
  `profeOcupActual` tinytext DEFAULT NULL,
  `numContact` int(11) DEFAULT NULL,
  PRIMARY KEY (`codDetalle`),
  KEY `ci` (`ci`),
  CONSTRAINT `candidatodetalle_ibfk_1` FOREIGN KEY (`ci`) REFERENCES `candidatos` (`ci`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `candidatodetalle` */

insert  into `candidatodetalle`(`codDetalle`,`ci`,`formacAca`,`formacProf`,`experLab`,`profeOcupActual`,`numContact`) values (0,2934298,'Bachiller en Ciencias y Letras - CREC - Año 1996 (Concepción) (Mejor Egresado) Abogado - Universidad Católica - Año 2002 (Concepción) (Alumno Distinguido) Especialista en Didáctica para la Educación Superior - UNC - Año 2010 (Concepción) Maestrí','Docente Escalafonado de la Universidad Nacional de Concepción - 2018. Diplomado en Curriculum por Competencia - Concepción - 2015 Diplomado en Evaluación por Competencia - Concepción - 2015 Estudio Actual: Doctorado en Ciencias Jurídicas -Universidad','Secretario General de la Junta Municipal de Concepción - Funcionario con carrera administrativa en la institución con 21 años de servicio, iniciando como Ordenanza Municipal. Salida: Año 2016. Afiliado al Partico ANR - Partido Colorado.','Docente Universitario de la UNC - Concepción - 2013/2021 Asesor en asuntos jurídicos. Asesor en asuntos legislativos.',971801011);

/*Table structure for table `candidatos` */

DROP TABLE IF EXISTS `candidatos`;

CREATE TABLE `candidatos` (
  `ci` int(11) NOT NULL,
  `nomApe` varchar(64) DEFAULT NULL,
  `codCand` int(11) DEFAULT NULL,
  `presentacion` text DEFAULT NULL,
  `codMov` int(11) DEFAULT NULL,
  `tipoCand` enum('TITULAR','SUPLENTE') DEFAULT NULL,
  `propuesta` text DEFAULT NULL,
  `img` varchar(64) DEFAULT NULL,
  `fechaNac` date DEFAULT NULL,
  `lugarNac` varchar(40) DEFAULT NULL,
  `email` varchar(32) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  PRIMARY KEY (`ci`),
  KEY `codCand` (`codCand`),
  KEY `codMov` (`codMov`),
  CONSTRAINT `candidatos_ibfk_1` FOREIGN KEY (`codCand`) REFERENCES `candidatura` (`codCand`),
  CONSTRAINT `candidatos_ibfk_2` FOREIGN KEY (`codMov`) REFERENCES `movimientos` (`codMov`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `candidatos` */

insert  into `candidatos`(`ci`,`nomApe`,`codCand`,`presentacion`,`codMov`,`tipoCand`,`propuesta`,`img`,`fechaNac`,`lugarNac`,`email`,`orden`) values (2934298,'SILVIO ANDRÉS AYALA SANABRIA',2,NULL,22,'TITULAR',NULL,'Silvio Andrés Ayala Sanabria.jpg','1979-04-26','CONCEPCIÓN','silvioandres79@gmail.com ',1);

/*Table structure for table `candidatura` */

DROP TABLE IF EXISTS `candidatura`;

CREATE TABLE `candidatura` (
  `codCand` int(11) NOT NULL,
  `descripcion` varchar(24) DEFAULT NULL,
  PRIMARY KEY (`codCand`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `candidatura` */

insert  into `candidatura`(`codCand`,`descripcion`) values (1,'INTENDENTE MUNICIPAL\r\n'),(2,'JUNTA MUNICIPAL\r\n');

/*Table structure for table `departamentos` */

DROP TABLE IF EXISTS `departamentos`;

CREATE TABLE `departamentos` (
  `codDep` int(11) NOT NULL,
  `departamento` varchar(24) NOT NULL,
  PRIMARY KEY (`codDep`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `departamentos` */

insert  into `departamentos`(`codDep`,`departamento`) values (1,'CONCEPCIÓN');

/*Table structure for table `distritos` */

DROP TABLE IF EXISTS `distritos`;

CREATE TABLE `distritos` (
  `codDist` int(11) NOT NULL,
  `codDep` int(11) DEFAULT NULL,
  `distrito` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`codDist`),
  KEY `codDep` (`codDep`),
  CONSTRAINT `distritos_ibfk_1` FOREIGN KEY (`codDep`) REFERENCES `departamentos` (`codDep`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `distritos` */

insert  into `distritos`(`codDist`,`codDep`,`distrito`) values (0,1,'CONCEPCIÓN');

/*Table structure for table `movimientos` */

DROP TABLE IF EXISTS `movimientos`;

CREATE TABLE `movimientos` (
  `codMov` int(11) NOT NULL,
  `codDist` int(11) DEFAULT NULL,
  `nombMov` varchar(64) DEFAULT NULL,
  `codPartido` int(11) DEFAULT NULL,
  `siglas` varchar(12) DEFAULT NULL,
  `img` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`codMov`),
  KEY `codDist` (`codDist`),
  KEY `codPartido` (`codPartido`),
  CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`codDist`) REFERENCES `distritos` (`codDist`),
  CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`codPartido`) REFERENCES `partidopolitico` (`codPartido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `movimientos` */

insert  into `movimientos`(`codMov`,`codDist`,`nombMov`,`codPartido`,`siglas`,`img`) values (9,0,'FRENTE DE INTEGRACION LIBERAL',1,'FIL',NULL),(22,0,'MOVIMIENTO REIVINDICACIÓN PUBLICANA',2,'MRR',NULL),(53,0,'FRENTE DE INTEGRACION LIBERAL DE CIUDADANOS ORGANIZADOS',1,'FILCO',NULL),(100,0,'DIALOGO AZUL',1,'DA',NULL),(2023,0,'FRENTE NUEVAS IDEAS',1,'FNI',NULL);

/*Table structure for table `partidopolitico` */

DROP TABLE IF EXISTS `partidopolitico`;

CREATE TABLE `partidopolitico` (
  `codPartido` int(11) NOT NULL,
  `descrPart` varchar(64) DEFAULT NULL,
  `siglas` char(8) DEFAULT NULL,
  PRIMARY KEY (`codPartido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `partidopolitico` */

insert  into `partidopolitico`(`codPartido`,`descrPart`,`siglas`) values (1,'PARTIDO LIBERAL RADICAL AUTÉNTICO','PLRA'),(2,'ASOCIACIÓN NACIONAL REPUBLICANA - PARTIDO COLORADO','ANR');

/*Table structure for table `preguntas` */

DROP TABLE IF EXISTS `preguntas`;

CREATE TABLE `preguntas` (
  `idPreg` int(11) NOT NULL,
  `detPreg` tinytext DEFAULT NULL,
  PRIMARY KEY (`idPreg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `preguntas` */

insert  into `preguntas`(`idPreg`,`detPreg`) values (1,'¿Cuál fue su trabajo o actividad anterior a ser pre candidato a Concejal?'),(2,'¿Cuáles son sus propuestas como pre candidato a Concejal?'),(3,'¿Cuáles cree que son los principales desafíos o problemas a resolver en el municipio o Comunidad para los próximos años?'),(4,'¿Cuáles son las actividades que realizará para acercarse a los ciudadanos y promover la participación ciudadana a futuro?'),(5,'¿Cómo afrontará la corrupción desde su nuevo cargo?'),(6,'¿Un mensaje corto que quiera dejar a la ciudadanía?'),(7,'Describa brevemente por qué un ciudadano debería votar por Usted.');

/*Table structure for table `redessociales` */

DROP TABLE IF EXISTS `redessociales`;

CREATE TABLE `redessociales` (
  `codRedes` int(11) NOT NULL,
  `redSocial` enum('FACEBOOK','INSTAGRAM','TWITTER') DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `codDetalle` int(11) DEFAULT NULL,
  PRIMARY KEY (`codRedes`),
  KEY `codDetalle` (`codDetalle`),
  CONSTRAINT `redessociales_ibfk_1` FOREIGN KEY (`codDetalle`) REFERENCES `candidatodetalle` (`codDetalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `redessociales` */

insert  into `redessociales`(`codRedes`,`redSocial`,`url`,`codDetalle`) values (0,'FACEBOOK','https://www.facebook.com/silvio.ayala.58',0);

/*Table structure for table `respuestas` */

DROP TABLE IF EXISTS `respuestas`;

CREATE TABLE `respuestas` (
  `idResp` int(11) NOT NULL AUTO_INCREMENT,
  `idPreg` int(11) DEFAULT NULL,
  `detResp` text DEFAULT NULL,
  `ci` int(11) DEFAULT NULL,
  PRIMARY KEY (`idResp`),
  KEY `idPreg` (`idPreg`),
  KEY `ci` (`ci`),
  CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`idPreg`) REFERENCES `preguntas` (`idPreg`),
  CONSTRAINT `respuestas_ibfk_2` FOREIGN KEY (`ci`) REFERENCES `candidatos` (`ci`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `respuestas` */

insert  into `respuestas`(`idResp`,`idPreg`,`detResp`,`ci`) values (1,1,'Docente Universitario - Asesor en asuntos jurídicos - Asesor en cuestiones legislativas. ',2934298),(2,2,'En materia administrativa: \r\n1) La necesidad de un estudio serio desde la Junta Municipal del Presupuesto Municipal, siendo urgente la reorganización y adecuación de los recursos hacia las necesidades mas necesarias del municipio. \r\n2) Apostamos a la transparencia, legislar para que sea obligatorio hacer publico y en tiempo real los ingresos y gastos municipales \"Lo publico deber ser publico\" \r\nEn materia de Educación:\r\n1) Promover un verdadero control serio y transparente de las inversiones provenientes de los recursos de Fonacide a fin de que sean realmente destinados a la educación, ya sea en infraestructura u otras necesidades. \r\n2) Gestionar que sea obligatorio la enseñanza en los colegios y universidades de la rama de derecho municipal a fin de que nuestros jóvenes tengan conocimiento de lo que conlleva pertenecer a un municipio y sobre todo manejar la normativa local, para lo cual es necesario gestionar ante las instancias pertinentes. \r\nEn materia de Salud: \r\n1) Desde el ámbito municipal, es primordial \"Poseer un marco legal que le de mayor funcionalidad y herramientas al Consejo Local de Salud\". \r\nEn materia de Obras Públicas y Planificación urbanístico \r\n1) Es necesario que el Municipio cuente con normas que regule y ordene seriamente su desarrollo urbano y territorial buscando evitar los problemas que se presentan debido a la falta de políticas claras sobre la cuestión. \r\n2) Es necesario analizar y proyectar el área urbano debido al crecimiento actual de la ciudad, estando ya desfasado las normas que lo regulan y que una vez actualizadas redundaran en una mejor planificación del municipio y por ente ayudara a la recaudación municipal que tendrá sus consecuencias en mayor cantidad de obras públicas. \r\n3) Es necesario una regulación y actualización del régimen de uso y ocupación del suelo. \r\n4) Es ineludible poseer reglas claras con relación a los loteamientos, que en gran medida, la poca seriedad en normas ha ayudado a la proliferación de loteamientos que no reúnen las condiciones legales, siendo actualmente un problema para los ciudadanos. \r\n5) Es ineludible trabajar por el mejoramiento de las calles de nuestra ciudad, situación que solamente será posible con gestión institucional y dando las herramientas legales a la Intendencia Municipal para ejecutar obras de mejoramiento de las arterias. \r\n6) Es ineludible la actualización del sistema de información catastral municipal. \r\n7) Es ineludible la gestión para la construcción y mantenimiento del sistema de desagüe pluvial de la ciudad, como también del sistema de defensa contra inundaciones, para lo cual es demasiado importante la labor legislativa en una gestión seria, eficaz y dinámica ante las autoridades nacionales en vista de que solamente es posible con recursos de otras instancias. \r\n8) Es necesario la regulación transparente y eficaz del sistema de recolección, disposición y tratamiento de residuos del municipio. \r\nEn Materia de Seguridad Vial \r\n1) La regulación del tránsito vehicular en las arterias de la ciudad, sigue siendo un tema pendiente en nuestra ciudad, para lo cual se necesita en primer lugar ordenanzas que reconozcas la problemática actual en lo vial y sobre todo plantee desde lo legislativo soluciones a estos inconvenientes. \r\n2) La problemática de los animales sueltos sigue siendo un gran inconveniente para nuestra ciudad, para lo cual además de una legislación que contemple la solución a los diferentes sectores, es necesario una gestión municipal buscando una solución coherente y que beneficie a todos, ya que no se puede dejar de atender que igualmente se debe buscar la solución para los propietarios de estos animales. \r\nEn materia de Ambiente: \r\n1) Establecer un marco legal que establezca la protección de los recursos naturales del municipio. Se debe entender que a pesar de estar penado una serie hechos que atentan contra la naturaleza, es igualmente de vital importancia establecer una política municipal clara de protección a estos recursos. \r\nEn materia de turismo: \r\n1) Incentivar el turismo fluvial es de vital importancia para generar recursos a los habitantes del municipio.\r\n',2934298),(3,3,'En primer lugar, buscar la transparencia administrativa. Buscar que la ciudadanía se involucre seriamente en el ámbito municipal con propuestas realizables. Gestionar desde la Junta Municipal lo referente al mejoramiento de las arterias de la ciudad, y consecuentemente los demás problemas viales. Atender la cuestión referente al desarrollo urbano y territorial del municipio. El problema de los residuos sólidos (Basuras domiciliarias)',2934298),(4,4,'Es fundamental que funcione la Comisiones Vecinales y Juntas Comunales de Vecinos a los efectos de canalizar por esta vía las inquietudes ciudadanas, debiendo para el efecto mantener desde lo legislativo una relación fluida con las mismas, siendo necesarias reuniones programadas constantemente. Además, no se puede negar que en la actualidad las redes sociales constituyen un recurso valido de expresión ciudadano, en consecuencia, se deberá atender la preocupaciones que llegan por esta vía y dar respuestas a las mismas, En temas transcendentales, llamar a audiencias públicas a fin de conocer el parecer de la ciudadanía. Dar participación a los gremios reconocidos, como también a los estudiantes universitarios en cuestiones municipales.',2934298),(5,5,'Con la transparencia, es decir hacer público lo público, y consecuentemente si se presentase hechos que ameritan denunciar ante las instancias pertinentes, realizarlo como corresponde en derecho. ',2934298),(6,6,'Participa, haz que pase....tú eliges a tus autoridades. ',2934298),(7,7,'Por la capacidad, por la idoneidad y por las propuestas serias que se plantean. ',2934298);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
