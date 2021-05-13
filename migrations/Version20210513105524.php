<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use App\Entity\FormeJuridique;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210513105524 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forme_juridique (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE societe_list (id INT AUTO_INCREMENT NOT NULL, forme_juridique_id INT NOT NULL, nom VARCHAR(255) NOT NULL, numero_siren VARCHAR(255) NOT NULL, date_immatriculation DATE NOT NULL, capital VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, numero1 VARCHAR(10) NOT NULL, type_voie1 VARCHAR(255) NOT NULL, nom_voie1 VARCHAR(255) NOT NULL, ville1 VARCHAR(255) NOT NULL, cp1 VARCHAR(10) NOT NULL, numero2 VARCHAR(10) DEFAULT NULL, type_voie2 VARCHAR(255) DEFAULT NULL, nom_voie2 VARCHAR(255) DEFAULT NULL, ville2 VARCHAR(255) DEFAULT NULL, cp2 VARCHAR(10) DEFAULT NULL, INDEX IDX_26E7C4099AEE68EB (forme_juridique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE societe_list_trace (id INT AUTO_INCREMENT NOT NULL, forme_juridique_id INT NOT NULL, nom VARCHAR(255) NOT NULL, numero_siren VARCHAR(255) NOT NULL, date_immatriculation DATE NOT NULL, capital VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, numero1 VARCHAR(10) NOT NULL, type_voie1 VARCHAR(255) NOT NULL, nom_voie1 VARCHAR(255) NOT NULL, ville1 VARCHAR(255) NOT NULL, cp1 VARCHAR(10) NOT NULL, numero2 VARCHAR(10) DEFAULT NULL, type_voie2 VARCHAR(255) DEFAULT NULL, nom_voie2 VARCHAR(255) DEFAULT NULL, ville2 VARCHAR(255) DEFAULT NULL, cp2 VARCHAR(10) DEFAULT NULL, action VARCHAR(45) NOT NULL, societe_id INT NOT NULL, INDEX IDX_F791653D9AEE68EB (forme_juridique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE societe_list ADD CONSTRAINT FK_26E7C4099AEE68EB FOREIGN KEY (forme_juridique_id) REFERENCES forme_juridique (id)');
        $this->addSql('ALTER TABLE societe_list_trace ADD CONSTRAINT FK_F791653D9AEE68EB FOREIGN KEY (forme_juridique_id) REFERENCES forme_juridique (id)');
    }

    public function postUp(Schema $schema): void
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        //Migration des données de forme juridique
        $handle = fopen("migrations/data/forme_juridique.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $formeJuridique = new FormeJuridique();
                $formeJuridique->setLibelle($line);
                $entityManager->persist($formeJuridique);
            }

            $entityManager->flush();
            fclose($handle);
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE societe_list DROP FOREIGN KEY FK_26E7C4099AEE68EB');
        $this->addSql('ALTER TABLE societe_list_trace DROP FOREIGN KEY FK_F791653D9AEE68EB');
        $this->addSql('DROP TABLE forme_juridique');
        $this->addSql('DROP TABLE societe_list');
        $this->addSql('DROP TABLE societe_list_trace');
    }
}
