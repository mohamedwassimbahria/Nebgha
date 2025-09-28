<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/formation')]
final class FormationController extends AbstractController
{
    #[Route(path: '/', name: 'app_formation_index', methods: ['GET', 'POST'])]
    public function index(FormationRepository $formationRepository, Request $request, EntityManagerInterface $entityManager,ProfesseurRepository $professeurRepository): Response
    {
        $form = $this->createForm(FormationType::class, new Formation());
        $updateForms = array();
        for ($i = 0; $i < count($formationRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(formationType::class, $formationRepository->findAll()[$i])->createView();
        }
        return $this->render('back/tableFormation.html.twig', [
            'formations' => $formationRepository->findAll(),
            'professeurs' =>$professeurRepository->findAll(),
            'form' => $form->createView(),
            'updateForms' => $updateForms,
        ]);
    }
    //la liste des formations 
    #[Route(path: '/f', name: 'app_formation_listeformation', methods: ['GET'])]
    public function index1(FormationRepository $formationRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        return $this->render('formation/formations.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }
    //afficher les détailles d'une formation 
    #[Route('/formation/{id}', name: 'formation_details')]
    public function details(Formation $formation): Response
    {
        return $this->render('formation/details.html.twig', [
            'formation' => $formation,
        ]);
    }
    #[Route('/new', name: 'app_formation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,FormationRepository $formationRepository): Response
    {
        $formation = new Formation();
        $updateForms = array();
        for ($i = 0; $i < count($formationRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(FormationType::class, $formationRepository->findAll()[$i])->createView();
        }
        $formation->setDateDebut(new \DateTime());
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
        }
        $hasErrorsCreate = true;

        return $this->render('back/tableFormation.html.twig', [
            'formations' => $formationRepository->findAll(),
            'form' => $form,
            'updateForms' => $updateForms,
            'hasErrorsCreate' => $hasErrorsCreate,
        ]);
    }

    #[Route('/{id}', name: 'app_formation_show', methods: ['GET'])]
    public function show(Formation $formation): Response
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
        ]);
    }

    #[Route('/{id}/edit/{formUpdateNumber}/', name: 'app_formation_edit', methods: ['GET', 'POST'])]
    public function edit($formUpdateNumber,FormationRepository $formationRepository,Request $request, Formation $formation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        $updateForms = array();
        for ($i = 0; $i < count($formationRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(FormationType::class, $formationRepository->findAll()[$i])->createView();
        }
        $form = $this->createForm(FormationType::class, new Formation());
        $updateform = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        $updateform->handleRequest($request);

        if ($updateform->isSubmitted() && $updateform->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
        }
        $entityManager->refresh($formation);

        return $this->render('back/tableFormation.html.twig', [
            'formations' => $formationRepository->findAll(),
            'form' => $form,
            'updateForms' => $updateForms,
            'formUpdateNumber' => $formUpdateNumber,
            'updateform' => $updateform->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_formation_delete', methods: ['POST'])]
    public function delete(Request $request, Formation $formation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($formation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
    }


}
