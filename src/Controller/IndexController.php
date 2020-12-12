<?php
namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Categories;
use App\Entity\CategoriesRecherche;
use App\Entity\PrixRecherche;
use App\Entity\Recherche;
use App\Form\ArticlesType;
use App\Form\CategoriesRechercheType;
use App\Form\CategoriesType;
use App\Form\PrixRechercheType;
use App\Form\RechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
//use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Response;
Use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class IndexController extends AbstractController  //tous les controller doivent hérité de cette class
{

/**
 *@Route("/",name="Accueil") 
 */
public function Acceuil(Request $request){
  return $this->render('articles/acceuil.html.twig');

}




   /*----------------------Recherche Article par Nom---------------------------------*/

/**
    *@Route("/Articles",name="article_list")
    */
           
            public function Articles(Request $request)
            {
              $recherche = new Recherche();
              $form = $this->createForm(RechercheType::class,$recherche);
              $form->handleRequest($request);
             //initialement le tableau des articles est vide, 
             //c.a.d on affiche les articles que lorsque l'utilisateur clique sur le bouton rechercher
              $articles= [];
              
             if($form->isSubmitted() && $form->isValid()) {
             //on récupère le nom d'article tapé dans le formulaire
              $nom = $recherche->getNom();   
              if ($nom!="") 
                //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
                $articles= $this->getDoctrine()->getRepository(Articles::class)->findBy(['nom' => $nom] );
              else   
                //si si aucun nom n'est fourni on affiche tous les articles
                $articles= $this->getDoctrine()->getRepository(Articles::class)->findAll();
             }
                return $this->render('articles/index.html.twig',[ 
                  'form' =>$form->createView(),'article'=> $articles]);
          }
  


   /*----------------------creation d'un nouveau Article -------------------------------------*/

 /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/article/new", name="new_article")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) {
        $article = new Articles();
      
        $form = $this->createForm(ArticlesType::class,$article);

        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
          $article = $form->getData();
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($article);
          $entityManager->flush();
  
          return $this->redirectToRoute('article_list');
        }
        return $this->render('articles/nouveau.html.twig',[
            'formAjouter' => $form->createView()]);
    }



    // creation d'un nouveau article avnt la creation du formulaire  articlesType
   
    // public function new(Request $request) {
    //     $article = new Articles();
    //     $form = $this->createFormBuilder($article)
    //       ->add('nom', TextType::class)
    //       ->add('description', TextType::class)
    //       ->add('image', TextType::class)
    //       ->add('prix', TextType::class)

    //       ->add('save', SubmitType::class, array(
    //         'label' => 'Créer'))->getForm();
          
  
    //     $form->handleRequest($request);//pour remplire les donnés
  
    //     if($form->isSubmitted() && $form->isValid()) {
    //       $article = $form->getData();
  
    //       $entityManager = $this->getDoctrine()->getManager();
    //       $entityManager->persist($article);
    //       $entityManager->flush();
  
    //       return $this->redirectToRoute('article_list');
    //     }
    //     return $this->render('articles/new.html.twig',[
    //         'form' => $form->createView()]);
    // }



      /*-----------------------------------afficher details article: un seul article-----------------------*/
      /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show($id) {
        $article = $this->getDoctrine()->getRepository(Articles::class)->find($id);
  
        return $this->render('articles/show.html.twig',
         array('article' => $article));  //array c'est pareil que []
      }

      /*--------------------------------------Modifier un article----------------------------------------------*/
  
    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/article/edit/{id}", name="edit_article")
     * Method({"GET", "POST"})
     */
    // 
    public function edit(Request $request, $id) {
        $article = new Articles();
        $article = $this->getDoctrine()->getRepository(Articles::class)->find($id);
  
        $form = $this->createForm(ArticlesType::class,$article);
  
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
  
          return $this->redirectToRoute('article_list');
        }
  
        return $this->render('articles/modifier.html.twig', [
            'formModifier' => $form->createView()]);
      }
      /*----------------------------------Supprimer un article ----------------------------------------------*/

  /**
    * @IsGranted("ROLE_EDITOR")
     * @Route("/article/delete/{id}",name="delete_article")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Articles::class)->find($id);
  
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();
  
        $response = new Response();
        $response->send();

        return $this->redirectToRoute('article_list');
      }

       /**
     * @Route("/categorie/newCat", name="new_categorie")
     * Method({"GET", "POST"})
     */
    public function newCategory(Request $request) {
        $categorie = new Categories();
      
        $form = $this->createForm(CategoriesType::class,$categorie);
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
          $article = $form->getData();
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($categorie);
          $entityManager->flush();
        }
        return $this->render('categories/newCategorie.html.twig',[
            'formNewCat' => $form->createView()]);
    }

  /*-------------Recherche Article par Categories----------------*/
    /**
     * @Route("/art_cat/", name="article_par_cat")
     * Method({"GET", "POST"})
     */
    public function articlesParCategorie(Request $request) {
      $categoriesRecherche  = new CategoriesRecherche();
      $form = $this->createForm(CategoriesRechercheType::class,$categoriesRecherche);
      $form->handleRequest($request);

      $articles= [];

      if($form->isSubmitted() && $form->isValid()) {
        $categories = $categoriesRecherche->getCategories();
       
        if ($categories!="") 
        {
          
          $articles= $categories->getArticles();
         // ou bien 
         //$articles= $this->getDoctrine()->getRepository(Article::class)->findBy(['category' => $category] );
        }
        else   
          $articles= $this->getDoctrine()->getRepository(Article::class)->findAll();
        }
      
      return $this->render('articles/articlesParCategorie.html.twig',[
        'form' => $form->createView(),'articles' => $articles]);
  }
  
  /*-------------Recherche Article par Prix compris entre min et max----------------*/


  /**
* @Route("/art_prix/", name="article_par_prix")
* Method({"GET"})
*/
public function articlesParPrix(Request $request)
{
  $prixRecherche = new PrixRecherche();  /// notre objet de type PrixRe....
  $form = $this->createForm(PrixRechercheType::class,$prixRecherche);
  $form->handleRequest($request);
  $articles= [];

  if($form->isSubmitted() && $form->isValid()) {
        $minPrix = $prixRecherche->getMinPrix();
        $maxPrix = $prixRecherche->getMaxPrix();
        $articles= $this->getDoctrine()->getRepository(Articles::class)->findByPriceRange($minPrix,$maxPrix);
  }
  return
            $this->render('articles/articlesParPrix.html.twig',[
               'formPrixRech' =>$form->createView(),
                'articles' => $articles]);
}


}



// /**
//       * @Route("/article/save")
//       */
//       public function save() {
//         $entityManager = $this->getDoctrine()->getManager();
 
//         $article = new Articles();
//         $article->setNom('Article 3');
//         $article->setDescription('Article 3');
//         $article->setImage('Article 3');

//         $article->setPrix(3000);
       
//         $entityManager->persist($article);
//         $entityManager->flush();
 
//         return new Response('Article enregisté avec id   '.$article->getId());
//       }

 





