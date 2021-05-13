<?php


namespace App\Controller;


use App\Entity\Blog;
use App\Repository\BlogRepository;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sentry\State\HubInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use function Symfony\Component\Translation\t;

class BlogController extends AbstractController
{
    private $logger;
    private $isDebug;

    public function __construct(LoggerInterface $logger, bool $isDebug){

        $this->logger = $logger;
        $this->isDebug = $isDebug;
    }

    /**
     * @Route ("/", name="app_homepage")
     * @return Response
     */
    public function homepage(BlogRepository $repository): Response
    {
        $blogs = $repository->findAllPostedOrderedByNewest();

        return $this->render('blog/homepage.html.twig', [
            'blogs' => $blogs,
        ]);
    }

    /**
     * @Route ("/blogs/new", name="app_new")
     */
    public function new(EntityManagerInterface $entityManager): Response
    {
        return new Response('Spunds like a great feature for v2');
    }

    /**
     * @Route ("/blogs/{slug}", name="app_blog_show")
     * @param $slug
     * @return Response
     */
    public  function show(Blog $blog): Response
    {
        if($this->isDebug){
            $this->logger->info('We are in debug mode');
        }

//(add -> $slug, MarkdownHelper $markdownHelper, EntityManagerInterface $entityManager <- in param of show() if you uncomment)
//        $repository = $entityManager->getRepository(Blog::class);
//        /** @var Blog|null $blog */
//        $blog = $repository->findOneBy(['slug' => $slug]);
//
//        if(!$blog){
//            throw $this->createNotFoundException(sprintf('no blog post found for "%s"', $slug));
//        }

        $comments = [
          'First `comment`',
          'second comment',
          'third comment',
        ];

        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route ("/blogs/{slug}/vote", name="app_blog_vote", methods="POST")
     */
    public function blogVote(Blog $blog, Request $request, EntityManagerInterface $entityManager)
    {
        $direction = $request->request->get('direction');

        if($direction === 'up'){
            $blog->upVote();
        }else if($direction === 'down'){
            $blog->downVote();
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_blog_show', [
            'slug' => $blog->getSlug(),
        ]);
    }
}