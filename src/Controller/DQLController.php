<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DQLController extends AbstractController
{
    /**
     * @Route("/dql", name="app_dql")
     */
    public function index(BlogRepository $blogRepository, Request $request, EntityManagerInterface $em): Response
    {
        $search = $request->query->get('search');

        if($search){
            $blogs = $blogRepository->getWithSearchDQL($search);
        }else{
            $blogs = $blogRepository->findAllOrderedDQL();
        }

        return $this->render('dql/DQL.html.twig', [
            'blogs' => $blogs,
        ]);
    }
}
