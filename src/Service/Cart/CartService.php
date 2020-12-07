<?php



namespace App\Service\Cart;

use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService {

    protected $session;
    protected $articlesRepository;

    
    public function __construct(SessionInterface $session,ArticlesRepository $articlesRepository)
    {
        $this->session = $session;
        $this->articlesRepository = $articlesRepository;

    }


    public function ajouter(int $id){ 


        $panier = $this->session->get('panier',[]);

        if(!empty( $panier[$id])){

            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }


     
        $this->session->set('panier',$panier);




    }


    public function supprimer(int $id){
        $panier = $this->session->get('panier',[]);
        if(!empty( $panier[$id]))  {
            unset( $panier[$id]);
    }
        $this->session->set('panier',$panier);



     }

     public function getPanierComplet() : array {

        $panier = $this->session->get('panier',[]);
        $panierAvecDonnees = [];
        foreach($panier as $id=> $quantites){

            $panierAvecDonnees[] =[
                'article' =>  $this->articlesRepository->find($id),
                'quantites'=> $quantites

            ];

        }
        return $panierAvecDonnees;

     }

    public function getTotal() : float 
    {
        $total = 0;
        // $panierAvecDonnees = $this->getPanierComplet();

        foreach($this->getPanierComplet() as $item){
            //$totalItem = $item['article']->getPrix() * $item['quantites'];
            $total +=$item['article']->getPrix() * $item['quantites'];
        }

        return $total;

    } 
}

