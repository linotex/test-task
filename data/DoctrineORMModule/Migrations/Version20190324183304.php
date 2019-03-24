<?php

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190324183304 extends AbstractMigration
{

    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO jobs(id, name) VALUES (1, 'Math'), (2, 'Geography'), (3, 'Biology')");

        $this->addSql("INSERT INTO teachers(id, first_name, last_name, age, job_id) VALUES 
          (1, 'TFN1', 'TLN1', 20, 1), 
          (2, 'TFN2', 'TLN2', 25, 2), 
          (3, 'TFN3', 'TLN3', 30, 3)");

        $this->addSql("INSERT INTO classes(id, name, day, room, start_hour, teacher_id) VALUES 
          (1, 'C11', 1, 1, 9, 1),
          (2, 'C12', 1, 1, 10, 2),
          (3, 'C13', 1, 2, 11, 3),
          (4, 'C14', 1, 2, 12, null),
          
          (5, 'C21', 2, 1, 9, 1),
          (6, 'C22', 2, 1, 10, 2),
          (7, 'C23', 2, 2, 11, 3),
          (8, 'C24', 2, 2, 12, null)");

        $this->addSql("INSERT INTO students(id, first_name, last_name, group_num) VALUES 
          (1, 'SFN1', 'SLN1', 1),
          (2, 'SFN2', 'SLN2', 1),
          (3, 'SFN3', 'SLN3', 2),
          (4, 'SFN4', 'SLN4', 2),
          (5, 'SFN5', 'SLN5', 3),
          (6, 'SFN6', 'SLN6', 3)");

        $this->addSql("INSERT INTO student_to_classes(student_id, classes_id) VALUES 
          (1, 1),
          (1, 2),
          (1, 3),
          (2, 1),
          (2, 2),
          (2, 3),
          (3, 2),
          (3, 4),
          (4, 2),
          (4, 3),
          (5, 3),
          (5, 4),
          (6, 1),
          (6, 2),
          (6, 3),
          (6, 4)");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("TRUNCATE student_to_classes");
        $this->addSql("TRUNCATE classes");
        $this->addSql("TRUNCATE teachers");
        $this->addSql("TRUNCATE jobs");
    }
}
