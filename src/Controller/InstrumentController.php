<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Form\InstrumentType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstrumentController extends AbstractController
{
    #[Route('/instrument/new', name: 'instrument_new')]
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
}
