<?php

namespace App\Controller;

use DateTime;
use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post", methods={"GET"}))
     */
    public function index(PostRepository $postRepository/*,SerializerInterface $serializer*/): Response
    {
        //$posts = $postRepository->findAll();
        //$postsNormalises =  $normalizer->normalize($posts, null, ['groups' => 'post:read']);
        //$json = json_encode($postsNormalises);
        //$json = $serializer->serialize($posts, 'json', ['groups' => 'post:read']);
        
        //$response = new Response($json, 200, ["Content-Type" => "application/json"]);
        //return $response;

        //$responseJson = new JsonResponse($json, 200, [], true);
        //return $responseJson;

        return $this->json($postRepository->findAll(), 200, [], ['groups' => 'post:read']);
    }

    /**
     * @Route("/api/post", name="api_post_store", methods={"POST"}))
     */
    public function store(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager,
    ValidatorInterface $validator): Response
    {
        $jsonRecu = $request->getContent();

        try {
            $post = $serializer->deserialize($jsonRecu, Post::class, 'json');
            $post->setCreatedAt(new DateTime());

            $errors = $validator->validate($post);
            if(count($errors) > 0) {
                return $this->json($errors, 400);
            }
            $entityManager->persist($post);
            $entityManager->flush();
    
            return $this->json($post, 201, [], ['groups' => 'post:read']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
