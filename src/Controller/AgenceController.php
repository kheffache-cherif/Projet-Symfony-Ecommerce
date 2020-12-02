<?php

namespace App\Controller;
use App\Entity\Voiture;
use App\Entity\Categorie;
use App\Entity\Recherche;
use App\Form\RechercheType;
use App\Form\VoitureType;
use App\Form\CategorieType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgenceController extends AbstractController
{
    /**
     * @Route("/agence", name="agence")
     */
    public function index(VoitureRepository $repo): Response  // fonction public
    {

        $voiture =$repo->findAll(); //('Titre de l\'Article' );

        return $this->render('agence/index.html.twig', [  //tu renvoies le fichier.index.html qui see trouve dans blog  synfony sais qu'il est dans template
            'controller_name' => 'AgenceController',
            'voitures' =>$voiture
        ]);
    }

  //  /** 
   //  * @Route("/",name="liste_voiture")
  //   */
   // public function home(){
        //return $this->render('agence/home.html.twig');
   // }


/**
*@Route("/",name="article_list")
*/
    public function home(Request $request)
    {
        $recherche = new Recherche();
        $form = $this->createForm(RechercheType::class,$recherche);
        $form->handleRequest($request);
        //initialement le tableau des voitures est vide,
        //c.a.d on affiche les voitures que lorsque l'utilisateur
        //clique sur le bouton rechercher
        $voitures= [];
        if($form->isSubmitted() && $form->isValid()) {
        //on récupère le titre d'article tapé dans le formulaire

        $titre = $recherche->getTitre();
        if ($titre!="")
        //si on a fourni un titr d'article on affiche tous les articles ayant ce titre
        
        $voitures= $this->getDoctrine()->getRepository(Voiture::class)->findBy(['titre' => $titre] );
        else
        //si si aucun titre n'est fourni on affiche tous les articles
        $voitures= $this->getDoctrine()->getRepository(Voiture::class)->findAll();
        }
        return
        $this->render('agence/home.html.twig',[ 
            'formRecherche' =>$form->createView(), 
            'voitures' => $voitures]);



    }





































    
    /** 
     * @Route("/agence/new", name="agence_creerVoiture")
     * @Route("/agence/{id}/edit",name="agence_dit")  //pour la mise à jour d'une voiture
     */
        //confusion entre new et {id} c'est pour ce la on remonte cette fonction avant 
    //public function createArticle(Request $request,EntityManagerInterface  $manager){
        public function form(Voiture $voiture = null,
         Request $request,EntityManagerInterface  $manager){
             if(!$voiture){
             $voiture = new Voiture();
             }

        $form = $this->createForm(VoitureType::class, $voiture);
            //gestion donner formulaire
        $form->handleRequest($request);// demander au formulaire d'analyser la requete
        
           //si le formulaire est soumis et si il est valide
           if($form->isSubmitted() && $form->isValid()) {
               if(!$voiture->getId()){
               }
               
               $manager->persist($voiture);  // demander au manager de l'enregister dans la base de donner
               $manager->flush();
               return $this->redirectToRoute('agence_show',['id' =>$voiture->getId()]);  //faire une redirection vert la page
           }
        return $this->render('agence/creerVoiture.html.twig',[
               'formVoiture' => $form->createView(),
               'editMode' => $voiture->getId()  !==null  //si id est vide    
    ]);
    }

/**
     * @Route("/agence/newCat", name="agence_newcategorie")
     * Method({"GET", "POST"})
     */
    public function newCategorie(Request $request) {
        $categorie = new Categorie();
      
        $form = $this->createForm(CategorieType::class,$categorie);
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
          $article = $form->getData();
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($categorie);
          $entityManager->flush();
        }
        return $this->render('agence/newCategorie.html.twig',[
            'formCategorie' => $form->createView()]);
    }
      /**
     * @Route("/agence/{id}",name="agence_show")   lier la fonction à une adresse  elle montre un seul article 
     */
         public function show(Voiture $voiture){
            return $this->render('agence/show.html.twig',[
              'voiture'=> $voiture
                    ]);
            }

   
    }





            

