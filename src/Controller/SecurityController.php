<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Form\EnregistrementType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
  /** 
   * @Route("/inscription", name="security_enregistrement")
   */
    public function enregistrement(Request $request,EntityManagerInterface $manager){// pour communiquer avec doctrine pour l'enregistrement

        $membre = new Membres();

        $form = $this->createForm(EnregistrementType::class,$membre);
            
        $form->handleRequest($request);  //analyse la request
        

        //$hash = $encoder->encodePassword($membre, $membre->getPasseword());
        

        if($form->isSubmitted() && $form->isValid())//si tout est soumi et tous les champs sont valides
            $manager->persist($membre);//persister dans le temps mon nouveau memebre
            $manager->flush();//fait le reelement

            //return $this->redirectToRoute('security_connexion');
    
        return $this->render('security/enregistrement.html.twig',
        [
                'form' => $form->createView()
        ]);

        }

        /** 
         * @Route("/connexion", name="security_connexion")
         */
        public function connexion(){
            return $this->render('security/connexion.html.twig');
        }
        /** 
         * @Route"/deconnexion,name="serurity_Deconnexion")
         */
        public function deconnexion(){
            
        }
}
