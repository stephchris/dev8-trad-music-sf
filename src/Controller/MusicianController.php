<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Entity\Musician;
use App\Form\InstrumentType;
use App\Form\MusicianType;
use App\Repository\MusicianRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MusicianController extends AbstractController
{
    #[Route('/musician', name: 'musician_list')]
    public function list(MusicianRepository $musicianRepository): Response
    {
        return $this->render('musician/index.html.twig', [
            'musicians' => $musicianRepository->findAll(),
        ]);
    }

    #[Route('/musician/{id}', name: 'musician_detail', requirements: ['id' => '\d+'])]
    public function detail(int $id, MusicianRepository $musicianRepository): Response
    {

        $musician = $musicianRepository->find($id);

        //si le musicien n'existe pas en BDD on retourne une erreur 404
        if ($musician === null) {
            throw $this->createNotFoundException();
        }
        return $this->render('musician/detail.html.twig', ['musician' => $musician]);
    }


    #[Route('/musician/profile', name: 'musician_profile')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $musician = $this->getUser();
        $form = $this->createForm(MusicianType::class, $musician);

        //on récupère les données du formulaire pour les mettre dans l'entité $musician
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //récupérer l'entity manager de Doctrine
            $entityManager = $doctrine->resetManager();
            //enregistrer les données en BDD
            $entityManager->persist($musician);
            $entityManager->flush();
            //rediriger l'internaute vers la page d'accueil
            return $this->redirectToRoute('homepage');
        }
        return $this->renderForm('musician/profile.html.twig', [
            'form' => $form,
        ]);

    }
}