<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     * @return Response
     */
    public function homepage(Environment $twigEnviroment): Response
    {
        /* fun example of using the Twig service directly
        $html = $twigEnviroment->render('blog/homepage.html.twig');
        return new Response($html);
        */

        return $this->render('blog/homepage.html.twig');
    }

    /**
     * @Route("/blogs/{slug}", name="app_blog_show")
     * @param $slug
     * @return Response
     */
    public  function show($slug): Response
    {
        $comments = [
          'First comment',
          'second comment',
          'third comment',
        ];

        dump($this);

        return $this->render('blog/show.html.twig', [
            'blog' => ucwords(str_replace('-', ' ', $slug)),
            'comments' => $comments,
        ]);


    }
}