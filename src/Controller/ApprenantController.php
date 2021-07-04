<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\Categorie;
use App\Entity\Evaluation;
use App\Repository\ApprenantRepository;
use App\Repository\EvaluationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
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
    #[Route('/update/{id}', name: 'UpdateApprenant')]
    public function formApp( Request $request, EntityManagerInterface $manager, ApprenantRepository $appRepo){
                
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
    #[Route('/addEval', name: 'newEvaluation')]
    public function formEval( Request $request, EntityManagerInterface $manager, EvaluationRepository $evaRepo){
                
        $evaluation = new Evaluation(); 

        //création du formulaire
        $form = $this->createFormBuilder($evaluation)
                     ->add('nom', TextType::class)
                     ->add('date', DateType::class)
                     ->add('heure', TimeType::class)
                     ->add('duree', TimeType::class)
                     ->add('categorie', EntityType::class,[
                           'class' => Categorie::class,
                           'choice_label' => 'type'
                     ])
                     ->getForm();

            $form->handleRequest($request);
            
            $apprenant = new Apprenant();

            //on verifie dans un premier temps si les données ont étés soumise correctement
            if ($form->isSubmitted() && $form->isValid()) {

                //si tout est ok, alors on l'insert dans la BDD
                $manager->persist($evaluation); //on persiste notre apprenant
                $manager->flush(); //on lance l'insertion directe

                return $this->render('apprenant/index.html.twig', [
                    'apprenant' => $apprenant
                ]);

            }

            return $this->render('evaluation/create.html.twig', [
                'formEval' => $form->createView()
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