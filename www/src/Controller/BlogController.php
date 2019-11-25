<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
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
        $title = "Mes articles";
        // $category = $articles->getCategory();
       
        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
            'title' => $title
            // 'category' => $category
        ]);
    }

    /** 
     * Method show an article on a single page : show twig
     * @Route("/blog/show/{id}", name="blog_show")
     */
    public function show(Article $article = null, Request $request){

        if(!$article){
            return $this->redirectToRoute('blog');
        }

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


    /** 
     * Method show all categories 
     * @Route("/blog/categories", name="blog_category")
     */
    public function categories(CategoryRepository $categoryRepo)
    {
        $categoryRepo = $this->getDoctrine()->getRepository(Category::class);
        $categories = $categoryRepo->findAll();
        $title = "Mes catégories";
       
        return $this->render('blog/categories.html.twig', [
            'categories' => $categories,
            'title' => $title
        ]);
    }

    // /** 
    //  * Method show an article on a single page : show twig
    //  * @Route("/blog/category/show/{id}", name="category_show")
    //  */
    // public function showCategory(Category $category = null, Request $request){

    //     if(!$category){
    //         return $this->redirectToRoute('blog/category');
    //     }

    //     return $this->render('blog/showCategory.html.twig', [
    //         'category' => $category
    //     ]);
    // }

    /** 
     * Double method : edit a category and save it in DB
     * if category's missing create a new one
     * @Route("blog/category/new", name="category_create")
     * @Route("blog/category/{id}/edit", name="category_edit")
     */
    public function formCategory(Request $request, ObjectManager $manager, Category $category = null)
    {   
        if (!$category) {
            $category = new Category();
            $title = "Nouvelle catégorie";
        }
        else{
            $title = "Edition de la catégorie n° ". $category->getId();
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('blog_category', [
                'id' => $category->getId()
            ]);
        }

        return $this->render('blog/newCategory.html.twig', [
            'formCategory' =>  $form->createView(),
            'title' => $title
        ]);
    }

    /** 
     * Delete category from DB and redirect to categories' page
     * @Route("/blog/category/{id}/delete", name="category_delete")
     */
    public function deleteCategory(ObjectManager $manager, Category $category)
    {
        $manager->remove($category);
        $manager->flush();

        return $this->redirectToRoute('blog_category');
    }
    

    
}
