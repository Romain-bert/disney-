<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateUserType;
use App\Form\LoginType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route('/create', 'createUserPage')]
    public function createUser(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $hasher): Response
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
                'form' => $form,
            ]
        );
    }

    private $authentificationsUtils;

    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authentificationsUtils = $authenticationUtils;
    }

    #[Route('/login', 'loginPage')]
    public function login(Request $request): Response
    {
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);
        $error = $this->authentificationsUtils->getLastAuthenticationError();
        $lastUsername = $this->authentificationsUtils->getLastUsername();


        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des données de formulaire
            $data = $form->getData();
            $email = $data['_username'];
            $password = $data['_password'];
        }
        return $this->render('login.html.twig',
            [
                'form' => $form->createView(),
                'error'=>$error,
                'lastUsername'=>$lastUsername,
            ]
        );
    }



    #[Route('/logout', 'logoutPage')]
    public function logout()
    {

    }

    public function adminAction()
    {
        if ($this->isGranted('ROLE_ADMIN')){

        }
    }

    private function getDoctrine(): ObjectManager
    {
        return $this->get('doctrine')->getManager();

    }

    private function get(string $serviceId)
    {
        return $this->container->get($serviceId);
    }
}


