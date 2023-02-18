<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230218103605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, immatriculation VARCHAR(255) NOT NULL, brand VARCHAR(20) NOT NULL, model VARCHAR(20) NOT NULL, nbr_places INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_user (car_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_46F9C2E5C3C6F69F (car_id), INDEX IDX_46F9C2E5A76ED395 (user_id), PRIMARY KEY(car_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, cp INT NOT NULL, longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, id_reservation_ride_id INT NOT NULL, created_at DATETIME NOT NULL, uptated_at DATETIME NOT NULL, INDEX IDX_42C849551155AD3E (id_reservation_ride_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ride (id INT AUTO_INCREMENT NOT NULL, city_departure_id INT NOT NULL, city_arrival_id INT NOT NULL, distance INT NOT NULL, departure_at DATETIME NOT NULL, arrival_at DATETIME NOT NULL, places_available INT NOT NULL, INDEX IDX_9B3D7CD0E7984489 (city_departure_id), INDEX IDX_9B3D7CD0F0127FF (city_arrival_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, reservation_id INT DEFAULT NULL, ride_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, login VARCHAR(20) NOT NULL, name VARCHAR(30) NOT NULL, surname VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649B83297E7 (reservation_id), INDEX IDX_8D93D649302A8A70 (ride_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_user ADD CONSTRAINT FK_46F9C2E5C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_user ADD CONSTRAINT FK_46F9C2E5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849551155AD3E FOREIGN KEY (id_reservation_ride_id) REFERENCES ride (id)');
        $this->addSql('ALTER TABLE ride ADD CONSTRAINT FK_9B3D7CD0E7984489 FOREIGN KEY (city_departure_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE ride ADD CONSTRAINT FK_9B3D7CD0F0127FF FOREIGN KEY (city_arrival_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649302A8A70 FOREIGN KEY (ride_id) REFERENCES ride (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car_user DROP FOREIGN KEY FK_46F9C2E5C3C6F69F');
        $this->addSql('ALTER TABLE car_user DROP FOREIGN KEY FK_46F9C2E5A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849551155AD3E');
        $this->addSql('ALTER TABLE ride DROP FOREIGN KEY FK_9B3D7CD0E7984489');
        $this->addSql('ALTER TABLE ride DROP FOREIGN KEY FK_9B3D7CD0F0127FF');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649B83297E7');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649302A8A70');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE car_user');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE ride');
        $this->addSql('DROP TABLE `user`');
    }
}
