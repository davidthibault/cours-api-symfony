<?php

namespace App\DataPersister;

use DateTime;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;


class PostPersister implements DataPersisterInterface
{
    protected $em;

    public function __construct(EntityManagerInterface $em) 
    {
        $this->em = $em;
    }
    public function supports($data): bool 
    {
        return $data instanceof Post;
    }

    public function persist($data) 
    {
        $data->setCreatedAt(new \DateTime());
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data) 
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}