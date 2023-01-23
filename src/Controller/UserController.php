<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateUserType;
use App\Form\LoginType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/create', 'createUserPage')]
    public function createUser(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $hasher):Response
    {
        $user = new User();
        $form = $this->createForm(CreateUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objet = $form->getData();
            $user->setPassword($hasher->hashPassword($user, $user->getPlainPassword()));
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('create.html.twig',
        [
            'form'=> $form,
        ]
        );
    }
    #[Route('/login', 'loginPage')]
    public function login():Response
    {
        $form = $this->createForm(LoginType::class);

        return $this->render('login.html.twig',
            [
                'form'=>$form->createView(),
            ]
        );
    }
}