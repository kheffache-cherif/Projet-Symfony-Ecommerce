<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
   /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface  $em, 
        UserPasswordEncoderInterface $encoder)
    {
        $membre = new Membres();
        $form  = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
        //l'objet $em sera affecté automatiquement grâce à l'injection des dépendances de symfony 4  
           $em->persist($user);
           $em->flush();  
           return $this->redirectToRoute('security_login');
        }
       return $this->render('security/registration.html.twig', 
                           ['form' =>$form->createView()]);
    }
}
