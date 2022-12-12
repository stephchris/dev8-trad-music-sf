<?php

namespace App\Controller;

use App\Repository\GigRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GigController extends AbstractController
{

    #[Route('/gig/{id}', name: 'gig_detail')]
    public function detail(int $id, GigRepository $gigRepository): Response
    {

        $gig = $gigRepository->find($id);
        return $this->render('gig/detail.html.twig', [
            'gig' => $gig
        ]);
    }

    #[Route('/gig', name: 'gig_list')]
    public function list(int $id, GigRepository $gigRepository): Response
    {

        return $this->render('gig/index.html.twig', [
            'gig' => $gigRepository->findFuture()
        ]);
    }





}
