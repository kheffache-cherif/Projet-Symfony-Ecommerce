<?php

namespace App\Controller;

//use App\Repository\ArticlesRepository;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\Session\Session;
//use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartService)
    {
           // $panierAvecDonnees = $cartService->getPanierComplet();  iciiiii
   

        //SessionInterface $session, ArticlesRepository $articlesRepository): Response
    
    //     $panier = $session->get('panier',[]);
    //     $panierAvecDonnees = [];
    //     foreach($panier as $id=> $quantites){

    //         $panierAvecDonnees[] =[
    //             'article' => $articlesRepository->find($id),
    //             'quantites'=> $quantites

    //         ];


    //     }
    //    // dd($panierAvecDonnees);
       // $total = $cartService->getTotal();    ////  la aaa

        // foreach($panierAvecDonnees as $item){
        //     $totalItem = $item['article']->getPrix() * $item['quantites'];
        //     $total +=$totalItem;
        // }


        return $this->render('cart/index.html.twig', [
            'items'=>$cartService->getPanierComplet(), //   icciiiiiii
            'total'=> $cartService->getTotal()  /// lllaa
        ]);
    }

/**
 * @Route("/panier/ajouter/{id}", name="cart_ajouter")
 */

    public function ajouter($id, CartService $cartService)
       {
                 $cartService->ajouter($id);

                 // LA Methode Ajouter au service  avant la creation d'un service 
    //SessionInterface $session)
    //Request $request){
       /*  //$session = $request->getSession();   utilisation du container de service 
        $panier = $session->get('panier',[]);

        if(!empty( $panier[$id])){

            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }


     
        $session->set('panier',$panier);
       // dd($session->get('panier')); */
       return $this->redirectToRoute("cart_index");

    }
    /**
     * @Route("/panier/supprimer/{id}", name="cart_supprimer")
     */
    public function supprimer($id,CartService $cartService)
    {
        $cartService->supprimer($id);
    
  /*   SessionInterface $session ){
        $panier = $session->get('panier',[]);
        if(!empty( $panier[$id]))  {
            unset( $panier[$id]);
    }
        $session->set('panier',$panier); */
        return $this->redirectToRoute("cart_index");
    }
}