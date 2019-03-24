<?php

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190324093722 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        /**
         * Table 'students'
         */
        $this->addSql("CREATE TABLE students
                        (
                            id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                            first_name varchar(255) NOT NULL,
                            last_name varchar(255) NOT NULL,
                            group_num tinyint NOT NULL
                        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");

        /**
         * Table 'groups'
         */
        $this->addSql("CREATE TABLE classes
                        (
                            id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                            name varchar(255) NOT NULL,
                            day tinyint NOT NULL,
                            room smallint NOT NULL,
                            start_hour tinyint NOT NULL,
                            teacher_id INT DEFAULT NULL
                        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");

        /**
         * Table 'teachers'
         */
        $this->addSql("CREATE TABLE teachers
                        (
                            id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                            first_name varchar(255) NOT NULL,
                            last_name varchar(255) NOT NULL,
                            age tinyint NOT NULL,
                            job_id INT DEFAULT NULL
                        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");

        /**
         * Table 'jobs'
         */
        $this->addSql("CREATE TABLE jobs
                        (
                            id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                            name varchar(255) NOT NULL                        
                        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");


        $this->addSql("CREATE TABLE student_to_classes
                        (
                            student_id int NOT NULL,
                            classes_id int NOT NULL
                        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE UNIQUE INDEX student_to_classes_student_id_group_id_uindex ON student_to_classes (student_id, classes_id)");

        $this->addSql("ALTER TABLE student_to_classes ADD CONSTRAINT student_to_classes_classes_id_fk
                        FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE");

        $this->addSql("ALTER TABLE student_to_classes ADD CONSTRAINT student_to_classes_students_id_fk
                        FOREIGN KEY (student_id) REFERENCES students (id) ON DELETE CASCADE");

        $this->addSql("ALTER TABLE classes ADD CONSTRAINT classes_teachers_id_fk
                        FOREIGN KEY (teacher_id) REFERENCES teachers (id) ON DELETE SET NULL");

        $this->addSql("ALTER TABLE teachers ADD CONSTRAINT teachers_jobs_id_fk
                        FOREIGN KEY (job_id) REFERENCES jobs (id) ON DELETE SET NULL");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP TABLE IF EXISTS student_to_classes");
        $this->addSql("DROP TABLE IF EXISTS students");
        $this->addSql("DROP TABLE IF EXISTS classes");
        $this->addSql("DROP TABLE IF EXISTS teachers");
        $this->addSql("DROP TABLE IF EXISTS jobs");
    }
}
