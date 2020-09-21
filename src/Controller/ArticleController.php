<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    /**
     * @Route("/", name="article_list")
     * @Method({"Get"})
     */
    public function index()
    {
        // $number = random_int(0, 100);

        // $articles = array("Art 1", "Art 2", "Art 3");
        // return new Response(
        //     '<html><body>Lucky number: '.$number.'</body></html>'
        // );

        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this->render("articles/index.html.twig", array("articles" => $articles));
    }

    // /**
    //  * @Route("/article/save")
    //  * @Method({"Get"})
    //  */
    // public function save(){
    //     $entityManager = $this->getDoctrine()->getManager();

    //     $article = new Article();
    //     $number = random_int(0, 100);
    //     $article->setTitle("article " . $number);
    //     $article->setbody("body " . $number);

    //     $entityManager->persist($article);
        
    //     $entityManager->flush();

    //     return new Response("Save an article with id of " . $article->getId());
    // }


    /**
     * @Route("/article/{id}", name="article_show")
     * @Method({"Get"})
     */
    public function show($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        return $this->render("articles/show.html.twig", array("article" => $article));
    }
}