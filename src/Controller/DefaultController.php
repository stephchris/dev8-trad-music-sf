<?php

namespace App\Controller;

use App\Repository\InstrumentRepository;
use App\Repository\MusicianRepository;
use App\Repository\GigRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(MusicianRepository $musicianRepository, GigRepository $gigRepository): Response
    {
        //Récupérer la liste des instruments en BDD (SELECT*FROM instrument )
        $musicians = $musicianRepository->findAll();
        $gigs = $gigRepository->findFuture();
        // appelle le fichier de template Twig avec la méthode render
        //permet d'envoyer des données du controller vers la vue homepage
        // retourner ce qu'il y a dans la page home
        return $this->render('default/homepage.html.twig', [
            'musicians' => $musicians,
            'gigs' => $gigs
        ]);


    }
}
