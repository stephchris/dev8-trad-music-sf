<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Entity\Pub;
use App\Form\InstrumentType;
use App\Repository\InstrumentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/instrument')]
class   InstrumentController extends AbstractController
{
    #[Route('/new', name: 'instrument_new')]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        //créer un nouvel instrument
        $instrument = new Instrument();


        //créer un formulaire pour un nouvel instrument
        $form = $this->createForm(InstrumentType::class, $instrument);

        //on récupère les données du formulaire pour les mettre dans l'entité $instrument
        $form->handleRequest($request);

        //on verifie que le formulaire est envoyé et que les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            //récupérer l'entity manager de Doctrine
            $entityManager = $doctrine->resetManager();
            //enregistrer les données en BDD
            $entityManager->persist($instrument);
            $entityManager->flush();
            //rediriger l'internaute vers la page d'accueil
            return $this->redirectToRoute('homepage');
        }
        return $this->renderForm('instrument/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Méthode qui permet d afficher la liste des instruments
     * cette méthode sera appelée en twig avec render(controller())
     * @param InstrumentRepository $instrumentRepository
     * @return Response
     */
    public function listInstruments(InstrumentRepository $instrumentRepository): Response
{
    $instruments = $instrumentRepository->findBy([], ['name' => 'ASC']); //SELECT*FROM instrument ORDER BY name ASC
    return $this->render('instrument/_list.html.twig', [
        'instruments' => $instruments
    ]);
}

    #[Route('/{id}', name: 'app_instrument_show', methods: ['GET'])]

    public function show(Instrument $instrument): Response
    {
        return $this->render('instrument/show.html.twig', [
            'instrument' => $instrument,
        ]);
    }

}
