<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;


use App\Entity\Article;
use App\Repository\ArticleRepository;// permet l'injection de la dependance "Repository des articles"
use App\Form\ArticleType;

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
     * @Route("/blog/listArticles", name="afficherListArticles" )
     */
    public function listArticles()
    {
                $repo2 = $this->getDoctrine()->getRepository(Article::class);
                $articles = $repo2->findAll();
                return $this->render('blog/liste-articles.html.twig', [
                    'controller_name' => 'BlogController',
                    'articles' => $articles
                    ]);

    }

    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article = null, Request $request, ObjectManager $manager) {
        //$article = new Article();
        if(!$article) {
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            if(!$article->getId()){
                $article->setCretedAt(new \DateTime());
            }
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', ['id'=> $article->getId()]);
        }
        if(!$article) {
            return $this->render('blog/create.html.twig', [
                'formArticle' => $form->createView(),
                'editMode' => $article->getId() !== null
            ]);
        }else{
            return $this->render('blog/edit.html.twig', [
                'formArticle' => $form->createView(),
                'editMode' => $article->getId() !== null
            ]);

        }
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
    /**
     * @Route("/blog_admin/{id}", name="blog_show_admin")
     */
    public function show_admin(Article $article)
    {    
        return $this->render('blog/show_admin.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="article_delet")
     * @param Article $article
     * @return
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function supprimerArticle(Article $article)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($article);
        $em->flush();
        //return $this->redirectToRoute('afficherListArticles');
        return $this->redirect($this->generateUrl("afficherListArticles"));
    }




}


