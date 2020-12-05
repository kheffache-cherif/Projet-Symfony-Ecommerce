<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Form\PasswordType;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

//encoder il faut le declarer dans security.yamal

class SecurityController extends AbstractController
{
   /**
* @Route("/inscription", name="security_inscription")
*/
public function inscription(Request $request, 
EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
{
    $membre = new Membres();

    $form = $this->createForm(InscriptionType::class,$membre);
        
    $form->handleRequest($request);  //analyse la request
    


    

    if($form->isSubmitted() && $form->isValid())//si tout est soumi et tous les champs sont valides
       
    $hash = $encoder->encodePassword( $membre,$membre->getPassword());
    $membre->setPassword($hash);
    
    

    
        $manager->persist($membre);//persister dans le temps mon nouveau memebre
        $manager->flush();//fait le reelement

        //return $this->redirectToRoute('security_connexion');

    return $this->render('security/inscription.html.twig',
    [
            'formInscription' => $form->createView()
    ]);

    }
    /**
 * @Route("/connexion",name="security_login")
 */
public function login(AuthenticationUtils  $authenticationUtils)
{
     // get the login error if there is one
$error = $authenticationUtils->getLastAuthenticationError();

// last username entered by the user
$lastUsername = $authenticationUtils->getLastUsername();
    
    return $this->render('security/connexion.html.twig',['lastUsername'=>$lastUsername,
                                                    'error' => $error]);
}
}


