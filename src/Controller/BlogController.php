<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Article;
use App\Repository\ArticleRepository;// permet l'injection de la dependance "Repository des articles"

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        //$repo = $this->getDoctrine()->getRepository(Article::class);
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

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article)
    {    
        //$repo = $this->getDoctrine()->getRepository(Article::class);  
        //$article = $repo->find($id); ||||||| injection de dependance - voir le service contenair de symfony
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }

}


