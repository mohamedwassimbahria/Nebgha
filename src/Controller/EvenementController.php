<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;



#[Route('/evenement')]
class EvenementController extends AbstractController
{
    #[Route(name: 'app_evenement_index', methods: ['GET', 'POST'])]
    public function index(Request $request, EvenementRepository $evenementRepository): Response
    {
   
    $searchType = $request->query->get('type');
    $searchTitre = $request->query->get('titre');

    // Appeler la méthode searchEvents du service pour rechercher les événements
    $evenements = $evenementRepository->searchEvents($searchTitre, $searchType);

        $form = $this->createForm(EvenementType::class, new Evenement());
        $updateForms = [];
        foreach ($evenementRepository->findAll() as $index => $evenement) {
            $updateForms[$index] = $this->createForm(EvenementType::class, $evenement)->createView();
        }
    
        return $this->render('back/tableEvenement.html.twig', [
            'evenements' => $evenements,
            'form' => $form->createView(),
            'updateForms' => $updateForms,
        ]);
     
    }
    
    #[Route(path: '/event', name: 'app_evenement_liste', methods: ['GET'])]
    public function index1(EvenementRepository $evenementRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        return $this->render('evenement/evenements.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }
    #[Route('/{id}/map', name: 'app_evenement_map', methods: ['GET'])]
    public function map(Evenement $evenement): Response
    {
        return $this->render('evenement/map.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/calendar', name: 'app_evenement_calendar', methods: ['GET'])]
    public function calendar(EvenementRepository $evenementRepository): Response
    {
        $evenements = $evenementRepository->findAll();
    
        $events = [];
        foreach ($evenements as $evenement) {
            $events[] = [
                'title' => $evenement->getTitre(), // Utilisez 'title' au lieu de 'titre'
                'start' => $evenement->getDateDebut()?->format('Y-m-d\TH:i:s'), // Utilisez 'start'
                'end' => $evenement->getDateFin()?->format('Y-m-d\TH:i:s'), // Utilisez 'end'
            ];
        }
    
        return $this->render('evenement/calendar.html.twig', [
            'events' => json_encode($events),
        ]);
    }
    
    
    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(EvenementRepository $evenementRepository,Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $updateForms = array();
        for ($i = 0; $i < count($evenementRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(EvenementType::class, $evenementRepository->findAll()[$i])->createView();
        }

        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }
        $hasErrorsCreate = true;
 
        return $this->render('back/tableEvenement.html.twig', [
            'evenements' => $evenementRepository->findAll(),
            'form' => $form,
            'updateForms' => $updateForms,
            'hasErrorsCreate' => $hasErrorsCreate,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(EvenementRepository $evenementRepository,Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        $updateForms = array();
        for ($i = 0; $i < count($evenementRepository->findAll()); $i++) {
            $updateForms[$i] = $this->createForm(EvenementType::class, $evenementRepository->findAll()[$i])->createView();
        }
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }
        $hasErrorsCreate = true;
       
        return $this->render('back/tableEvenement.html.twig', [
            'evenements' => $evenementRepository->findAll(),
            'form' => $form,
            'updateForms' => $updateForms,
            'hasErrorsCreate' => $hasErrorsCreate,
        ]);

    }

    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
  
}
