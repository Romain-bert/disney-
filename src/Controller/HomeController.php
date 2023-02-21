<?php

namespace App\Controller;

use App\Entity\Videos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', 'homePage')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $videos = $entityManager->getRepository(Videos::class)->findAll();


        return $this->render('home/index.html.twig', [
            'videos' => $videos,
        ]);

    }
}
