<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Favorite;
use App\Entity\Videos;
use App\Form\CommentType;
use App\Form\FavoriteType;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    #[Route('/video/{id}', name: 'app_video')]
    public function show(Videos $video, int $id, EntityManagerInterface $entityManager, Request $request,FavoriteRepository $favoriteRepository): Response
    {
        $user = $this->getUser();
        $video = $entityManager->getRepository(Videos::class)->find($id);
        $comments = $entityManager->getRepository(Comment::class)->findBy([
            "filmId" => $id
        ]);

        $comment = new Comment();
        $comment->setUserId($user);
        $comment->setFilmId($video);



        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objet = $form->getData();
            $entityManager->persist($comment);
            $entityManager->flush();
        }

        $favorite = new Favorite();
        $favorite->setIdUser($user);
        $favorite->setIdVideo($video);

        $favoriteForm = $this->createForm(FavoriteType::class, $favorite);
        $favoriteForm->handleRequest($request);

        if ($favoriteForm->isSubmitted() && $favoriteForm->isValid()) {
            $entityManager->persist($favorite);
            $entityManager->flush();

            $this->addFlash('success', 'Video added to favorites!');
        }

        return $this->render('video.html.twig', [
            'video' => $video,
            'form' => $form->createView(),
            'comments' => $comments,
            'favoriteForm' => $favoriteForm->createView(),
        ]);
    }
}
