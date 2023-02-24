<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\Bundle\DoctrineBundle\Registry;

class UserCrudController extends AbstractCrudController
{
    private $entityManager;

    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            TextField::new('first_name'),
            TextField::new('last_name'),
            TextField::new('password'),
            BooleanField::new('IsBanned')->hideOnForm()
        ];
    }

    public function banUser(EntityManagerInterface $entityManager, User $id)
    {
        $user = $entityManager->getRepository(User::class)->find($id);
        $user->setIsBanned(true);
        $this->entityManager->flush();
    }



}
