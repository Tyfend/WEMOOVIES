<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /** 
     * Method show all articles in index twig
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $articleRepo)
    {
        $articleRepo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $articleRepo->findAll();
        $title= "Mes articles";

        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
            'title' => $title
        ]);
    }

    /** 
     * Method show an article on a single page : show twig
     * @Route("/blog/show/{id}", name="blog_show")
     */
    public function show(Article $article, Request $request){
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }

    /** 
     * Double method : edit an article and save it in DB
     * if article's missing create a new one
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Request $request, ObjectManager $manager, Article $article = null)
    {   
        if (!$article) {
            $article = new Article();
            $title = "Nouvel article";
        }
        else{
            $title = "Edition de l'article n° ". $article->getId();
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', [
                'id' => $article->getId()
            ]);
        }

        return $this->render('blog/new.html.twig', [
            'formArticle' =>  $form->createView(),
            'title' => $title
        ]);
    }

    /** 
     * Delete article from DB and redirect to blog
     * @Route("/blog/{id}/delete", name="blog_delete")
     */
    public function delete(ObjectManager $manager, Article $article)
    {
        $manager->remove($article);
        $manager->flush();

        return $this->redirectToRoute('blog');
    }



    

    
}
