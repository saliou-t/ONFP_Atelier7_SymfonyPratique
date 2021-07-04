<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Repository\ApprenantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApprenantController extends AbstractController
{
    #[Route('/apprenant', name: 'apprenant')]
    public function index( ApprenantRepository $Apprenantrepo): Response
    {
        $apprenants = $Apprenantrepo->findAll();

        return $this->render('apprenant/index.html.twig', [
            'apprenant' => $apprenants
        ]);
    }
}
