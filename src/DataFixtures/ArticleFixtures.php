<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;

class ArticleFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
      $faker = \Faker\Factory::create('fr_FR'); // https://github.com/fzaninotto/Faker#fakerprovideruseragent

      // je fais 3 categorie fakees
      for($i = 1; $i <= 3; $i++){
        $category = new Category();
        $category->setTitle($faker->sentence())
                 ->setDescription($faker->paragraph());
        $manager->persist($category);

        // je fais entre 4 et 6 articles
        for($j = 1; $j <= mt_rand(4, 6); $j++){
          $article = new Article();

          $content = '<p>'.join($faker->paragraphs(5), '</p><p>').'</p>';
          $article->setTitle($faker->sentence())
                  ->setAuthor($faker->name)
                  ->setContent($content)
                  ->setImage($faker->imageUrl())
                  ->setCretedAt($faker->dateTimeBetween('-6 months'))
                  ->setCategory($category);
          $manager->persist($article);

          // On defini les commentaire relatifs a l'article ci-dessus
          for($k = 1; $k < mt_rand(4, 10); $k++)
          {
            $comment = new Comment();
            $content = '<p>'.join($faker->paragraphs(5), '</p><p>').'</p>';
            
            $now = new \DateTime();
            $interval = $now->diff($article->getCretedAt());//difference entre maintenant et la date de l'article
            $days =$interval->days; // depuis combien de jours l'article est mis en ligne
            $minimum = '-'.$days.'days'; // -100 days par exemple

            $comment->setAuthor($faker->name)
                    ->setContent($content)
                    ->setCreatedAt($faker->dateTimeBetween($minimum))
                    ->setArticle($article);
            $manager->persist($comment);

          }
        }
      }
      $manager->flush();
    }
}
