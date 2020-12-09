<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Form\ModifierMembreType;
use App\Repository\MembresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/admin", name="admin_")
*/
class AdminController extends AbstractController
{
/**
    * @Route("/utilisateurs", name="utilisateurs")
    */
    public function membresList(MembresRepository $membre) {
        return $this->render("admin/membres.html.twig",[
        'membres' => $membre->findAll()]);
        }

/**
    * @Route("/utilisateurs/modifier/{id}", name="modifier_utilisateur")
    */
    public function editUser(Request $request, Membres $membre, EntityManagerInterface $manager) {
    $form = $this->createForm(ModifierMembreType::class,$membre);
    $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('admin_utilisateurs');
        }
            return $this->render('admin/modifierMembres.html.twig', [
                'formMembre' => $form->createView()
            ]);
        }
}