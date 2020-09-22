<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/article/new", name="article_new")
     * @Method({"Get", "Post"})
     */
    public function new(Request $request)
    {
        $article = new Article();

        $form = $this->createFormBuilder($article)
            ->add("title", TextType::class, array("attr" =>
            array("class" => "form-control")))
            ->add("body", TextareaType::class, array(
                "required" => false,
                "attr" =>
                array("class" => "form-control")
            ))
            ->add("save", SubmitType::class, array(
                "label" => "Create",
                "attr" =>
                array("class" => "btn btn-primary mt-3")
            ))
            ->getForm();


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);

            $entityManager->flush();

            return $this->redirectToRoute("article_list");
        }

        return $this->render("articles/new.html.twig", array("form" => $form->createView()));
    }

/**
     * @Route("/article/edit/{id}", name="article_edit")
     * @Method({"Get", "Post"})
     */
    public function edit(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $form = $this->createFormBuilder($article)
            ->add("title", TextType::class, array("attr" =>
            array("class" => "form-control")))
            ->add("body", TextareaType::class, array(
                "required" => false,
                "attr" =>
                array("class" => "form-control")
            ))
            ->add("save", SubmitType::class, array(
                "label" => "Create",
                "attr" =>
                array("class" => "btn btn-primary mt-3")
            ))
            ->getForm();


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($article);

            $entityManager->flush();

            return $this->redirectToRoute("article_list");
        }

        return $this->render("articles/edit.html.twig", array("form" => $form->createView()));
    }


    /**
     * @Route("/article/{id}", name="article_show")
     * @Method({"Get"})
     */
    public function show($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        return $this->render("articles/show.html.twig", array("article" => $article));
    }

    /**
     * @Route("/article/delete/{id}", name="article_delete")
     * @Method({"Delete"})
     */
    public function delete($id)
    {
        
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
// die(var_dump($id));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);

        $entityManager->flush();

        $response = new Response();
        $response->send();
    }
}
