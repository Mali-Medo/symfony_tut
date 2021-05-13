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
        $blog = new Blog();
        $blog->setTitle('Missing pants')
            ->setSlug('missing-pants-'.rand(0, 1000))
            ->setDescription('Does anyone have a spell to call your pants back?')
            ->setBlogText(<<<EOF
Hi! So... I'm having a *weird* day. Yesterday, I cast a spell to make
my dishes wash themselves. But while I was casting it,
I slipped a little and I think `I also hit my pants with the spell`.

When I woke up this morning, I caught a quick glimpse of my pants
opening the front door and walking out! I've been out all afternoon
(with no pants mind you) searching for them.

Does anyone have a spell to call your pants back?
EOF
            );

        if(rand(1, 10) > 2){
            $blog->setPostedAt(new \DateTime(sprintf('-%d days', rand(1, 100))));
        }

        $blog->setVotes(rand(-20, 50));

        $entityManager->persist($blog);
        $entityManager->flush();

        return new Response(sprintf(
            'Well hello! The shiny new question is id #%d, slug %s',
            $blog->getId(),
            $blog->getSlug(),
        ));
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