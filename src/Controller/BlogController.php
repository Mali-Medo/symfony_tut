<?php


namespace App\Controller;


use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
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
    public  function show($slug, MarkdownParserInterface $markdownParser, CacheInterface $cache): Response
    {
        $comments = [
          'First `comment`',
          'second comment',
          'third comment',
        ];

        $blogText = 'I\'ve been turned into a cat, any *thoughts* on how to turn back? While I\'m **adorable**, I don\'t really care for cat food.';

        $parsedBlogText = $cache->get('markdown_'.md5($blogText), function () use ($blogText, $markdownParser) {
            $parsedBlogText = $markdownParser->transformMarkdown($blogText);
        });

        dd($markdownParser);

        return $this->render('blog/show.html.twig', [
            'blog' => ucwords(str_replace('-', ' ', $slug)),
            'blogText' => $parsedBlogText,
            'comments' => $comments,
        ]);


    }
}