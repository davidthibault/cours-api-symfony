<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post", methods={"GET"}))
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        dd($posts);
        return $this->render('api_post/index.html.twig', [
            'controller_name' => 'ApiPostController',
        ]);
    }
}
