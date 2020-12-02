<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    /** 
     * @Route("/",name="home")
     */
    public function home(){
        return $this->render('agence/home.html.twig');
    }


      /**
     * @Route("/agence/{id}",name="agence_show")   lier la fonction à une adresse
     */
         public function show(Voiture $voiture){
            return $this->render('agence/show.html.twig',[
              'voiture'=> $voiture
                    ]);
            }
}
