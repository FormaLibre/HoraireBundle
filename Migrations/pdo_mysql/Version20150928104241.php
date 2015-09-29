<?php

namespace FormaLibre\HoraireBundle\Migrations\pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2015/09/28 10:42:43
 */
class Version20150928104241 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE formalibre_horairebundle_timeslot (
                id INT AUTO_INCREMENT NOT NULL, 
                period_id INT DEFAULT NULL, 
                num_period VARCHAR(255) NOT NULL, 
                date DATE NOT NULL, 
                day VARCHAR(255) NOT NULL, 
                begin_hour TIME NOT NULL, 
                end_hour TIME NOT NULL, 
                INDEX IDX_2C05A568EC8B7ADE (period_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE formalibre_horairebundle_period (
                id INT AUTO_INCREMENT NOT NULL, 
                schoolYearName VARCHAR(255) NOT NULL, 
                schoolYear_begin DATE NOT NULL, 
                schoolYear_end DATE NOT NULL, 
                schoolDay_begin_hour TIME NOT NULL, 
                schoolDay_end_hour TIME NOT NULL, 
                visibility TINYINT(1) NOT NULL, 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE formalibre_horairebundle_rights (
                id INT AUTO_INCREMENT NOT NULL, 
                role_id INT DEFAULT NULL, 
                mask INT NOT NULL, 
                INDEX IDX_FB786C36D60322AC (role_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE formalibre_horairebundle_personnalTimeSlot (
                id INT AUTO_INCREMENT NOT NULL, 
                teacher_id INT DEFAULT NULL, 
                group_id INT DEFAULT NULL, 
                local_id INT DEFAULT NULL, 
                local_reservation_id INT DEFAULT NULL, 
                cursus_name VARCHAR(255) NOT NULL, 
                timeSlot_id INT DEFAULT NULL, 
                INDEX IDX_E4A3CD8B369D8075 (timeSlot_id), 
                INDEX IDX_E4A3CD8B41807E1D (teacher_id), 
                INDEX IDX_E4A3CD8BFE54D947 (group_id), 
                INDEX IDX_E4A3CD8B5D5A2101 (local_id), 
                INDEX IDX_E4A3CD8BF014436 (local_reservation_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            ALTER TABLE formalibre_horairebundle_timeslot 
            ADD CONSTRAINT FK_2C05A568EC8B7ADE FOREIGN KEY (period_id) 
            REFERENCES formalibre_horairebundle_period (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE formalibre_horairebundle_rights 
            ADD CONSTRAINT FK_FB786C36D60322AC FOREIGN KEY (role_id) 
            REFERENCES claro_role (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE formalibre_horairebundle_personnalTimeSlot 
            ADD CONSTRAINT FK_E4A3CD8B369D8075 FOREIGN KEY (timeSlot_id) 
            REFERENCES formalibre_horairebundle_timeslot (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE formalibre_horairebundle_personnalTimeSlot 
            ADD CONSTRAINT FK_E4A3CD8B41807E1D FOREIGN KEY (teacher_id) 
            REFERENCES claro_user (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE formalibre_horairebundle_personnalTimeSlot 
            ADD CONSTRAINT FK_E4A3CD8BFE54D947 FOREIGN KEY (group_id) 
            REFERENCES claro_group (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE formalibre_horairebundle_personnalTimeSlot 
            ADD CONSTRAINT FK_E4A3CD8B5D5A2101 FOREIGN KEY (local_id) 
            REFERENCES formalibre_reservation_resource (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE formalibre_horairebundle_personnalTimeSlot 
            ADD CONSTRAINT FK_E4A3CD8BF014436 FOREIGN KEY (local_reservation_id) 
            REFERENCES formalibre_reservation (id) 
            ON DELETE CASCADE
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE formalibre_horairebundle_personnalTimeSlot 
            DROP FOREIGN KEY FK_E4A3CD8B369D8075
        ");
        $this->addSql("
            ALTER TABLE formalibre_horairebundle_timeslot 
            DROP FOREIGN KEY FK_2C05A568EC8B7ADE
        ");
        $this->addSql("
            DROP TABLE formalibre_horairebundle_timeslot
        ");
        $this->addSql("
            DROP TABLE formalibre_horairebundle_period
        ");
        $this->addSql("
            DROP TABLE formalibre_horairebundle_rights
        ");
        $this->addSql("
            DROP TABLE formalibre_horairebundle_personnalTimeSlot
        ");
    }
}