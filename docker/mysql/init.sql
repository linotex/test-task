CREATE DATABASE IF NOT EXISTS school CHARACTER SET utf8 COLLATE utf8_general_ci;
USE school;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `day` tinyint(4) NOT NULL,
  `room` smallint(6) NOT NULL,
  `start_hour` tinyint(4) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
INSERT INTO `classes` VALUES (1,'C11',1,1,9,1),(2,'C12',1,1,10,2),(3,'C13',1,2,11,3),(4,'C14',1,2,12,NULL),(5,'C21',2,1,9,1),(6,'C22',2,1,10,2),(7,'C23',2,2,11,3),(8,'C24',2,2,12,NULL);
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
INSERT INTO `jobs` VALUES (1,'Math'),(2,'Geography'),(3,'Biology');
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `version` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
INSERT INTO `migrations` VALUES ('20190324093722','2019-03-24 23:35:00'),('20190324183304','2019-03-24 23:35:00');
UNLOCK TABLES;

--
-- Table structure for table `student_to_classes`
--

DROP TABLE IF EXISTS `student_to_classes`;
CREATE TABLE `student_to_classes` (
  `student_id` int(11) NOT NULL,
  `classes_id` int(11) NOT NULL,
  UNIQUE KEY `student_to_classes_student_id_group_id_uindex` (`student_id`,`classes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student_to_classes`
--

LOCK TABLES `student_to_classes` WRITE;
INSERT INTO `student_to_classes` VALUES (1,1),(2,1),(6,1),(1,2),(2,2),(3,2),(4,2),(6,2),(1,3),(2,3),(4,3),(5,3),(6,3),(3,4),(5,4),(6,4);
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group_num` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
INSERT INTO `students` VALUES (1,'SFN1','SLN1',1),(2,'SFN2','SLN2',1),(3,'SFN3','SLN3',2),(4,'SFN4','SLN4',2),(5,'SFN5','SLN5',3),(6,'SFN6','SLN6',3);
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `age` tinyint(4) NOT NULL,
  `job_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
INSERT INTO `teachers` VALUES (1,'TFN1','TLN1',20,1),(2,'TFN2','TLN2',25,2),(3,'TFN3','TLN3',30,3);
UNLOCK TABLES;

ALTER TABLE student_to_classes ADD CONSTRAINT student_to_classes_classes_id_fk FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE;
ALTER TABLE student_to_classes ADD CONSTRAINT student_to_classes_students_id_fk FOREIGN KEY (student_id) REFERENCES students (id) ON DELETE CASCADE;
ALTER TABLE classes ADD CONSTRAINT classes_teachers_id_fk FOREIGN KEY (teacher_id) REFERENCES teachers (id) ON DELETE SET NULL;
ALTER TABLE teachers ADD CONSTRAINT teachers_jobs_id_fk FOREIGN KEY (job_id) REFERENCES jobs (id) ON DELETE SET NULL;