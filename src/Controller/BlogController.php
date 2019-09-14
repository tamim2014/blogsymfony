<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        // find(12): charge l'article numero 12
        // findOneByAuthor('Ali'): charge l'article ecrit par ali
        // findByAuthor('Ali'): charge tous les article ecrit par Ali
        //findAll(): charge tous les articles
        $articles = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
            ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig',[
            'title'  => "Bienvenue ici les amis !",
            'age' => 31
        ]);
    }

}


