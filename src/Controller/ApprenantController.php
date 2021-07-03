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
    public function form( Request $request, EntityManagerInterface $manager, ApprenantRepository $appRepo){
                
        $appr = new Apprenant();
        $apprs = $appRepo->findAll();

        $apprenant = new Apprenant();
        //création du formulaire
        $form = $this->createFormBuilder($apprenant)
                     ->add('nom', TextType::class)
                     ->add('prenom', TextType::class)
                     ->add('adresse', TextType::class)
                     ->add('niveau_etude', TextType::class)
                     ->add('telephone', TextType::class)
                     ->add('attentes', TextareaType::class)
                     ->getForm();

            $form->handleRequest($request);

            //on verifie dans un premier temps si les données ont étés soumise correctement
            if ($form->isSubmitted() && $form->isValid()) {

                //si tout est ok, alors on l'insert dans la BDD
                $manager->persist($apprenant); //on persiste notre apprenant
                $manager->flush(); //on lance l'insertion directe

                return $this->render('apprenant/index.html.twig', [
                    'apprenant' => $apprs
                ]);
            }


            return $this->render('apprenant/addApprenant.html.twig', [
                'formApp' => $form->createView()
            ]);
    }

    #[Route('/DeleteApprenant/{id}', name: 'deleteApp')]
    public function supprimerApp($id, EntityManagerInterface $manager,ApprenantRepository $appRepo ){
        
        // on essaie de trouver notre apprenant par son ID
        $resultat = $appRepo->findOneById($id);
        
        //on cherche d'abord si l'apprenant exite ou pas 
        if (!$resultat) {
            die();
        }
        else{
            $manager->remove($resultat);
            $manager->flush();
        }
        $apprenants = $appRepo->findAll();

        return $this->render('apprenant/index.html.twig', [
            'apprenant' => $apprenants
        ]);
    }
}