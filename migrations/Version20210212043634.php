<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212043634 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $articles = [
            ['id' => 1, 'title' => 'First news', 'content' => 'First content', 'photo' => 'blabla.jpg', 'create_date' => '2020-01-02'],
            ['id' => 2, 'title' => 'Second news', 'content' => 'Second content', 'photo' => 'ups.jpg', 'create_date' => '2021-01-02'],
            ['id' => 3, 'title' => 'Third news', 'content' => 'Third content', 'photo' => 'aba.jpg', 'create_date' => '2020-02-02'],
            ['id' => 4, 'title' => 'Fourth news', 'content' => 'Fourth content', 'photo' => 'asd.jpg', 'create_date' => '2021-02-02'],
            ['id' => 5, 'title' => 'Fifth news', 'content' => 'Fifth content', 'photo' => 'ald.jpg', 'create_date' => '2021-02-02'],
            ['id' => 6, 'title' => 'Sixth news', 'content' => 'Sixth content', 'photo' => 'gsdd.jpg', 'create_date' => '2021-02-02'],
            ['id' => 7, 'title' => 'Seventh news', 'content' => 'Seventh content', 'photo' => 'hd.jpg', 'create_date' => '2021-02-02'],
        ];

        $tags = [
            ['id' => 1, 'name' => '#first_tag'],
            ['id' => 2, 'name' => '#second_tag'],
            ['id' => 3, 'name' => '#third_tag'],
            ['id' => 4, 'name' => '#fourth_tag'],
            ['id' => 5, 'name' => '#fifth_tag'],
        ];

        foreach($articles as $article) {
            $this->addSql('INSERT INTO article (id, title, content, photo, create_date) VALUES(:id, :title, :content, :photo, :create_date)', $article);
        }

        foreach($tags as $tag) {
            $this->addSql('INSERT INTO tag (id, name) VALUES (:id, :name)', $tag);
        }

        $this->addSql('INSERT INTO article_tag(article_id, tag_id) VALUES(1, 1)');
        $this->addSql('INSERT INTO article_tag(article_id, tag_id) VALUES(1, 2)');
        $this->addSql('INSERT INTO article_tag(article_id, tag_id) VALUES(1, 4)');
        $this->addSql('INSERT INTO article_tag(article_id, tag_id) VALUES(4, 1)');
        $this->addSql('INSERT INTO article_tag(article_id, tag_id) VALUES(4, 5)');
        $this->addSql('INSERT INTO article_tag(article_id, tag_id) VALUES(3, 2)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
    }
}
