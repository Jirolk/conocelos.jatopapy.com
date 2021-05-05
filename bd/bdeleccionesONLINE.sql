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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`jattugco_candidatos` /*!40100 DEFAULT CHARACTER SET latin1 */;

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

insert  into `candidatos`(`ci`,`nomApe`,`codCand`,`presentacion`,`codMov`,`tipoCand`,`propuesta`,`img`,`fechaNac`,`lugarNac`,`email`,`orden`) values (2837172,'ÓSCAR PULCIANO CABRAL GUENS',2,NULL,10,'TITULAR','Como legislador municipal puedo someter a consideración las propuestas que tengo y no dependerán sólo de mí ninguna, sino más bien, de mis colegas y sobre todo del ejecutivo. Quiero apoyar las buenas propuestas venga del sector que venga siempre y cuando sea un bien para la comunidad. Transparencia en mi gestión. Apoyo a las múltiples necesidades sociales. Apoyo al deporte, la educación y la salud sobre todo lo demás. Los temas viales, industriales, y estructurales de la ciudad deben abordarse de a poco e ir dando solución en equipo desde la concejalía se puede propiciar estos puntos pero no se puede ser contundente debido a que se necesita de la coordinación y coherencia en la participación del resto de los concejales. La calidad humana, cultural y la formación de los compañeros podría facilitar llegar a soluciones prácticas e inteligentes de la problemática distrital en todos sus aspectos.','Oscar Pulciano Cabral Guens.jpeg','1980-06-03','CONCEPCIÓN','oscarcabral@hotmail.com',3),(2934298,'SILVIO ANDRÉS AYALA SANABRIA',2,NULL,22,'TITULAR',NULL,'Silvio Andrés Ayala Sanabria.jpg','1979-04-26','CONCEPCIÓN','silvioandres79@gmail.com ',1),(4190913,'BERNARDO VILLALBA AYALA',1,NULL,22,'TITULAR','a. Urbanización: a través del desarrollo y ejecución de proyectos de sustentabilidad tanto arquitectónico (pavimentado y/o asfaltado de calles; comisiones vecinales; recolección de basura; desagües pluviales o cuneteos, agua potable) así como socioeconómicos (casco comercial organizado) \r\nb. Salud: Brindar mayor eficiencia y cobertura en cuanto a salud a través del consejo distrital de la salud. Otorgando el protagonismo correspondiente para que juntos, en equipo podamos dar estos accesos a Toda la Ciudadanía. \r\nc. Reactivación De La Escuela Taller: el objetivo principal es brindar tanto a jóvenes como a adultos la posibilidad de acceder a educación de mandos medios con rápida salida laboral para que la inserción laboral respectiva pueda realizarse en corto plazo. \r\nd. Apoyo a Bomberos Voluntarios.\r\n','Bernardo Villalba Ayala,jpeg','1986-05-30','CONCEPCIÓN','berniv2021@gmail.com',1),(5576975,'FELIX FERNANDO ZAVALA AYALA.',2,NULL,10,'TITULAR','	Acompañar y trabajar con las comisiones vecinales para generar proyectos que benefician a los pobladores del barrio o compañía. \r\n	Fomentar las diferentes asociaciones y comités para poder conectar con empresas y así poder colocar sus productos. \r\n	Ordenamiento del tránsito, señalización, semáforos. \r\n	Gestionar la modernización del mercado municipal y terminal de ómnibus. \r\n	Gestionar la rehabilitación de espacios verdes para el esparcimiento y el turismo. Ejemplo: monumento al indio símbolo de la ciudad, monumento a María Auxiliadora, Puerto antiguo. \r\n	Proponer la creación de una Perrera Municipal o Corralón Municipal para animales sueltos y en situación de calle.\r\n','Fernando Zavala.png','1993-03-07','CONCEPCIÓN ','fernandozavala1993@gmail.com',12);

/*Table structure for table `candidatura` */

DROP TABLE IF EXISTS `candidatura`;

CREATE TABLE `candidatura` (
  `codCand` int(11) NOT NULL,
  `descripcion` varchar(24) DEFAULT NULL,
  PRIMARY KEY (`codCand`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `candidatura` */

insert  into `candidatura`(`codCand`,`descripcion`) values (1,'INTENDENTE MUNICIPAL\r\n'),(2,'JUNTA MUNICIPAL\r\n');

/*Table structure for table `contacto` */

DROP TABLE IF EXISTS `contacto`;

CREATE TABLE `contacto` (
  `idContacto` int(11) NOT NULL AUTO_INCREMENT,
  `codDetalle` int(11) DEFAULT NULL,
  `numCntacto` int(11) DEFAULT NULL,
  PRIMARY KEY (`idContacto`),
  KEY `codDetalle` (`codDetalle`),
  CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`codDetalle`) REFERENCES `candidatodetalle` (`codDetalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `contacto` */

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

insert  into `movimientos`(`codMov`,`codDist`,`nombMov`,`codPartido`,`siglas`,`img`) values (9,0,'FRENTE DE INTEGRACION LIBERAL',1,'FIL','FILA9.jpeg'),(10,0,'ESPERANZA REPUBLICANA',2,'ER','ER10.jpeg'),(13,0,'FRENTE DE INTEGRACION LIBERAL DE CIUDADANOS ORGANIZADOS',1,'FILCO','FILCO13.jpeg'),(22,0,'MOVIMIENTO REIVINDICACIÓN REPUBLICANA',2,'MRR','MRR22.jpeg'),(36,0,'FUERZA RENOVADORA REPUBLICANA',2,'FRR','RR36.jpeg'),(100,0,'DIALOGO AZUL',1,'DA','DA.jpeg'),(2023,0,'FRENTE NUEVAS IDEAS',1,'FNI','FrenteNuevasIdeas2023.jpg');

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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;

/*Data for the table `respuestas` */

insert  into `respuestas`(`idResp`,`idPreg`,`detResp`,`ci`) values (1,1,'Docente Universitario - Asesor en asuntos jurídicos - Asesor en cuestiones legislativas. ',2934298),(2,2,'En materia administrativa: \r\n1) La necesidad de un estudio serio desde la Junta Municipal del Presupuesto Municipal, siendo urgente la reorganización y adecuación de los recursos hacia las necesidades mas necesarias del municipio. \r\n2) Apostamos a la transparencia, legislar para que sea obligatorio hacer publico y en tiempo real los ingresos y gastos municipales \"Lo publico deber ser publico\" \r\nEn materia de Educación:\r\n1) Promover un verdadero control serio y transparente de las inversiones provenientes de los recursos de Fonacide a fin de que sean realmente destinados a la educación, ya sea en infraestructura u otras necesidades. \r\n2) Gestionar que sea obligatorio la enseñanza en los colegios y universidades de la rama de derecho municipal a fin de que nuestros jóvenes tengan conocimiento de lo que conlleva pertenecer a un municipio y sobre todo manejar la normativa local, para lo cual es necesario gestionar ante las instancias pertinentes. \r\nEn materia de Salud: \r\n1) Desde el ámbito municipal, es primordial \"Poseer un marco legal que le de mayor funcionalidad y herramientas al Consejo Local de Salud\". \r\nEn materia de Obras Públicas y Planificación urbanístico \r\n1) Es necesario que el Municipio cuente con normas que regule y ordene seriamente su desarrollo urbano y territorial buscando evitar los problemas que se presentan debido a la falta de políticas claras sobre la cuestión. \r\n2) Es necesario analizar y proyectar el área urbano debido al crecimiento actual de la ciudad, estando ya desfasado las normas que lo regulan y que una vez actualizadas redundaran en una mejor planificación del municipio y por ente ayudara a la recaudación municipal que tendrá sus consecuencias en mayor cantidad de obras públicas. \r\n3) Es necesario una regulación y actualización del régimen de uso y ocupación del suelo. \r\n4) Es ineludible poseer reglas claras con relación a los loteamientos, que en gran medida, la poca seriedad en normas ha ayudado a la proliferación de loteamientos que no reúnen las condiciones legales, siendo actualmente un problema para los ciudadanos. \r\n5) Es ineludible trabajar por el mejoramiento de las calles de nuestra ciudad, situación que solamente será posible con gestión institucional y dando las herramientas legales a la Intendencia Municipal para ejecutar obras de mejoramiento de las arterias. \r\n6) Es ineludible la actualización del sistema de información catastral municipal. \r\n7) Es ineludible la gestión para la construcción y mantenimiento del sistema de desagüe pluvial de la ciudad, como también del sistema de defensa contra inundaciones, para lo cual es demasiado importante la labor legislativa en una gestión seria, eficaz y dinámica ante las autoridades nacionales en vista de que solamente es posible con recursos de otras instancias. \r\n8) Es necesario la regulación transparente y eficaz del sistema de recolección, disposición y tratamiento de residuos del municipio. \r\nEn Materia de Seguridad Vial \r\n1) La regulación del tránsito vehicular en las arterias de la ciudad, sigue siendo un tema pendiente en nuestra ciudad, para lo cual se necesita en primer lugar ordenanzas que reconozcas la problemática actual en lo vial y sobre todo plantee desde lo legislativo soluciones a estos inconvenientes. \r\n2) La problemática de los animales sueltos sigue siendo un gran inconveniente para nuestra ciudad, para lo cual además de una legislación que contemple la solución a los diferentes sectores, es necesario una gestión municipal buscando una solución coherente y que beneficie a todos, ya que no se puede dejar de atender que igualmente se debe buscar la solución para los propietarios de estos animales. \r\nEn materia de Ambiente: \r\n1) Establecer un marco legal que establezca la protección de los recursos naturales del municipio. Se debe entender que a pesar de estar penado una serie hechos que atentan contra la naturaleza, es igualmente de vital importancia establecer una política municipal clara de protección a estos recursos. \r\nEn materia de turismo: \r\n1) Incentivar el turismo fluvial es de vital importancia para generar recursos a los habitantes del municipio.\r\n',2934298),(3,3,'En primer lugar, buscar la transparencia administrativa. Buscar que la ciudadanía se involucre seriamente en el ámbito municipal con propuestas realizables. Gestionar desde la Junta Municipal lo referente al mejoramiento de las arterias de la ciudad, y consecuentemente los demás problemas viales. Atender la cuestión referente al desarrollo urbano y territorial del municipio. El problema de los residuos sólidos (Basuras domiciliarias)',2934298),(4,4,'Es fundamental que funcione la Comisiones Vecinales y Juntas Comunales de Vecinos a los efectos de canalizar por esta vía las inquietudes ciudadanas, debiendo para el efecto mantener desde lo legislativo una relación fluida con las mismas, siendo necesarias reuniones programadas constantemente. Además, no se puede negar que en la actualidad las redes sociales constituyen un recurso valido de expresión ciudadano, en consecuencia, se deberá atender la preocupaciones que llegan por esta vía y dar respuestas a las mismas, En temas transcendentales, llamar a audiencias públicas a fin de conocer el parecer de la ciudadanía. Dar participación a los gremios reconocidos, como también a los estudiantes universitarios en cuestiones municipales.',2934298),(5,5,'Con la transparencia, es decir hacer público lo público, y consecuentemente si se presentase hechos que ameritan denunciar ante las instancias pertinentes, realizarlo como corresponde en derecho. ',2934298),(6,6,'Participa, haz que pase....tú eliges a tus autoridades. ',2934298),(7,7,'Por la capacidad, por la idoneidad y por las propuestas serias que se plantean. ',2934298),(8,1,'La actividad inmediata anterior es el ejercicio de mi profesión de abogado.',4190913),(9,2,'a. Urbanización: a través del desarrollo y ejecución de proyectos de sustentabilidad tanto arquitectónico (pavimentado y/o asfaltado de calles; comisiones vecinales; recolección de basura; desagües pluviales o cuneteos, agua potable) así como socioeconómicos (casco comercial organizado) \r\nb. Salud: Brindar mayor eficiencia y cobertura en cuanto a salud a través del consejo distrital de la salud. Otorgando el protagonismo correspondiente para que juntos, en equipo podamos dar estos accesos a Toda la Ciudadanía. \r\nc. Reactivación De La Escuela Taller: el objetivo principal es brindar tanto a jóvenes como a adultos la posibilidad de acceder a educación de mandos medios con rápida salida laboral para que la inserción laboral respectiva pueda realizarse en corto plazo. \r\n',4190913),(10,3,'Los principales desafíos que tenemos en la comunidad es la falta de transparencia de la administración de los recursos con lo que contamos; las deudas contraídas; definir un mecanismo para lograr un desarrollo socio-económico sostenible a través de dirigencias, alianzas estratégicas tanto con entes nacionales como internacionales para poder levantarlos. Así como la inyección económica a través del sector privado, quienes podrán invertir en la ciudad generando fuente de empleo digno para toda la ciudadanía, así como ya se está haciendo en el distrito, como por ejemplo lo hace la planta de celulosa.',4190913),(11,4,'La principal actividad es acercarnos a las familias y a la ciudanía en general, considerando todo el protocolo sanitario para que de esta forma podamos hacerles llegar nuestro proyecto. Concepción necesita un cambio, y esto debe verse reflejado en la estrategia del proyecto presentado considerando todos los desafíos que asumiremos y el objetivo que se logrará a través de una gestión transparente y eficiente.',4190913),(12,5,'Mediante una administración transparente, una auditoría al inicio de la asunción de los trabajos y con posterioridad a eso mediante una rendición de cuenta con la participación conjunta de todas las comisiones, una participación activa de la ciudadanía en el manejo de los bienes públicos.',4190913),(13,6,'Hoy es el momento de lograr el cambio, hoy es el momento de la alternancia, la oportunidad que cada uno tenemos de lograr el progreso y desarrollo que anhelamos desde ya hace tiempo, tu apoyo es imprescindible, tu voto hará la diferencia.',4190913),(14,7,'Porque sé que cada ciudadano/a se identifica con mis ganas de desarrollo y progreso sobre todo, el cambio en la administración pública es necesario, y considero tener los valores, la formación profesional y la empatía para lograr una eficiente y por sobre todo transparente administración.',4190913),(15,1,'Comunicador Social en diferentes medios de la ciudad.',5576975),(16,2,'	Acompañar y trabajar con las comisiones vecinales para generar proyectos que benefician a los pobladores del barrio o compañía. \r\n	Fomentar las diferentes asociaciones y comités para poder conectar con empresas y así poder colocar sus productos. \r\n	Ordenamiento del tránsito, señalización, semáforos. \r\n	Gestionar la modernización del mercado municipal y terminal de ómnibus. \r\n	Gestionar la rehabilitación de espacios verdes para el esparcimiento y el turismo. Ejemplo: monumento al indio símbolo de la ciudad, monumento a María Auxiliadora, Puerto antiguo. \r\n	Proponer la creación de una Perrera Municipal o Corralón Municipal para animales sueltos y en situación de calle.\r\n',5576975),(17,3,'	La infraestructura vial. \r\n	Desagües Pluviales. \r\n	Ordenamiento de la ciudad.\r\n',5576975),(18,4,'Realizando reuniones en los diferentes barrios y comunidades y promover audiencias públicas con todas las autoridades y así escuchar la necesidad y elaborar o gestionar proyectos que beneficie a la ciudadanía en general.',5576975),(19,5,'El rol principal de un concejal es ser el contralor de los bienes públicos, cuando encuentre alguna irregularidad haré la denuncia correspondiente en el pleno de la junta y en el Ministerio Público.',5576975),(20,6,'Queremos hacer una política diferente, buscar el bien común para todos, buscar proyectos de gran envergadura que realmente tenga un impacto a corto, mediano y largo plazo.',5576975),(21,7,'Queremos cambiar la historia de Concepción, somos capital departamental ciudad cabecera y vamos a trabajar para conseguir una nueva Concepción. Vamos a pelear por una ciudad ordenada, limpia, saludable y atractiva para inversionistas.',5576975),(22,1,'	Gerente General - Autoparque Concepción.\r\n	Gerente Propietario - La Norteña Comercial\r\n	Gerente General - OCESA ( Óscar Cabral Emprendimientos S.A. ) Concepción.\r\n',2837172),(23,2,'Como legislador municipal puedo someter a consideración las propuestas que tengo y no dependerán sólo de mí ninguna, sino más bien, de mis colegas y sobre todo del ejecutivo. Quiero apoyar las buenas propuestas venga del sector que venga siempre y cuando sea un bien para la comunidad. Transparencia en mi gestión. Apoyo a las múltiples necesidades sociales. Apoyo al deporte, la educación y la salud sobre todo lo demás. Los temas viales, industriales, y estructurales de la ciudad deben abordarse de a poco e ir dando solución en equipo desde la concejalía se puede propiciar estos puntos pero no se puede ser contundente debido a que se necesita de la coordinación y coherencia en la participación del resto de los concejales. La calidad humana, cultural y la formación de los compañeros podría facilitar llegar a soluciones prácticas e inteligentes de la problemática distrital en todos sus aspectos.',2837172),(24,3,'La corrupción, la falta de transparencia, el personalismo, el revanchismo partidario en la lucha por el poder que hace olvidar el objetivo principal que es la Ciudad de Concepción en este caso, la educación vial, los desagües pluviales en coordinación con la pavimentación, la salud pública, el gasto institucional y el cuoteo político serían los principales entre muchos más. ',2837172),(25,4,'En pandemia es muy difícil hablar de actividades cuando aún todo es muy incierto. Podría mencionar un montón de actividades pero es totalmente relativa a la situación de la pandemia y cómo se va encarando por de pronto las redes son una buena opción y el apoyo institucional a todas las cuestiones sociales que están en aumento por la misma situación que vivimos a nivel mundial. sin embargo un buen desempeño en las funciones es excelente incentivo a promover la participación ciudadana.',2837172),(26,5,'Principalmente no siendo corrupto. Difícilmente en nuestro pueblo se puede decidir por los actos de los demás pero si se puede no ser uno de ellos. Además no propiciar la corrupcion, no ayudar a que aumente y si se tiene las pruebas necesarias denunciar. Muchas veces los mismos órganos contralores son los corruptos. Un movimiento inteligente donde la ciudadanía termine ganando es la mejor opción en tiempos donde lo inteligente es tan poco valorado y la violencia está a la orden del día',2837172),(27,6,'Sean partícipes del cambio. No es suficiente protestar, también hay que entrar en la cancha y jugar. ',2837172),(29,7,'Porque soy una opción no política que representa a todos los que estamos cansados de ver la misma gente en los mismos cargos dirigidos por los mismos líderes y teniendo los mismos resultados. Soy parte del verdadero cambio por que jamás interactúe con la politiquería. Cada pueblo tiene los gobernantes que se merece dice un dicho y yo quiero creer que el pueblo debe gobernar si se inmiscuye en estas cuestiones y forma parte activa del verdadero cambio que es desde adentro. ',2837172);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
