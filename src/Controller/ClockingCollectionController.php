<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Clocking;
use App\Entity\ClockingDetail;
use App\Form\CollaboratorClockingType;
use App\Form\ManagerClockingType;
use App\Repository\ClockingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/clockings')]
class ClockingCollectionController extends
    AbstractController
{

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/create/collaborator', name: 'app_Clocking_create_collaborator', methods: [
        'GET',
        'POST',
    ])]
    public function createClockingCollaborator(
        EntityManagerInterface $entityManager,
        Request                $request,
    ): Response
    {
        $form = $this->createForm(CollaboratorClockingType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clocking = $form->getData();

            $entityManager->persist($clocking);
            $entityManager->flush();

            return $this->redirectToRoute('app_Clocking_list');
        }

        $formView = $form->createView();

        return $this->render('app/Clocking/create_collaborator.html.twig', [
            'form' => $formView,
        ]);
    }

    #[Route('/create/manager', name: 'app_Clocking_create_manager', methods: [
        'GET',
        'POST',
    ])]
    public function createClockingManager(EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(ManagerClockingType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $date = $data['date'];

            $clockingDetails = $data['clockingDetails'];

            foreach ($data['users'] as $user) {
                $clocking = new Clocking();
                $clocking->setClockingUser($user);
                $clocking->setDate($date);

                foreach ($clockingDetails as $clockingDetailData) {
                    $clockingDetail = new ClockingDetail();
                    $clockingDetail->setProject($clockingDetailData->getProject());
                    $clockingDetail->setDuration($clockingDetailData->getDuration());
                    $clocking->addClockingDetail($clockingDetail);
                    $entityManager->persist($clockingDetail);
                }
                $entityManager->persist($clocking);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_Clocking_list');
        }else{
            $errors = $form->getErrors(true);
            foreach ($errors as $error) {
                $form->addError(new FormError($error->getMessage()));
            }
        }

        return $this->render('app/Clocking/create_manager.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param \App\Repository\ClockingRepository $clockingRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/', name: 'app_Clocking_list', methods: ['GET'])]
    public function listClockings(ClockingRepository $clockingRepository): Response
    {
        $clockings = $clockingRepository->findAll();

        return $this->render('app/Clocking/list.html.twig', [
            'clockings' => $clockings,
        ]);
    }
}
