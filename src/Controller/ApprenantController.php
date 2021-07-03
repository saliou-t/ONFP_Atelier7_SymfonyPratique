<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\Categorie;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApprenantController extends AbstractController
{
    #[Route('/', name: 'apprenant')]
    public function index(ApprenantRepository $Apprenantrepo): Response
    {
        $apprenants = $Apprenantrepo->findAll();

        return $this->render('apprenant/index.html.twig', [
            'apprenant' => $apprenants
        ]);
    }

    #[Route('/addapprenant', name: 'addApprenant')]
    public function form( Request $request, EntityManagerInterface $manager){
                
        $apprenant = new Apprenant();
        //création du formulaire
        $form = $this->createFormBuilder($apprenant)
                     ->add('nom', TextType::class)
                     ->add('prenom', TextType::class)
                     ->add('niveau_etude', TextType::class)
                     ->add('telephone', TextType::class)
                     ->add('attentes', TextareaType::class)
                     ->getForm();

            return $this->render('apprenant/addApprenant.html.twig', [
                'formApp' => $form->createView()
            ]);
        
    }
}