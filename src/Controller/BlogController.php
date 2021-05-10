<?php


namespace App\Controller;


use App\Service\MarkdownHelper;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class BlogController extends AbstractController
{
    private $logger;
    private $isDebug;

    public function __construct(LoggerInterface $logger, bool $isDebug){

        $this->logger = $logger;
        $this->isDebug = $isDebug;
    }

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
    public  function show($slug, MarkdownHelper $markdownHelper): Response
    {
        if($this->isDebug){
            $this->logger->info('We are in debug mode');
        }


        $comments = [
          'First `comment`',
          'second comment',
          'third comment',
        ];

        $blogText = 'I\'ve been turned into a cat, any *thoughts* on how to turn back? While I\'m **adorable**, I don\'t really care for cat food.';

        $parsedBlogText = $markdownHelper->parse($blogText);

       // dump($cache);

        return $this->render('blog/show.html.twig', [
            'blog' => ucwords(str_replace('-', ' ', $slug)),
            'blogText' => $parsedBlogText,
            'comments' => $comments,
        ]);


    }
}