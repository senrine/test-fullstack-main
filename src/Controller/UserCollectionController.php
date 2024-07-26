<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/users')]
class UserCollectionController extends
    AbstractController
{

    /**
     * @param \App\Repository\UserRepository $userRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/', name: 'app_User_list', methods: ['GET'])]
    public function listUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('app/User/list.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/create', name: 'app_User_create', methods: ['POST', 'GET'])]
    public function createUser(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CreateUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user = $form->getData();
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('app_User_list');
            } catch (\Exception $e) {
                $form->addError(new FormError('Ce matricule est déjà utilisé. Veuillez en choisir un autre.'));
            }

        }

        return $this->render('app/User/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
