<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Product;
use AppBundle\Entity\Produit;
use AppBundle\Form\ProduitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
     public function indexAction(Request $request)
     {
         $em = $this->getDoctrine()->getManager();
         $produits = $em->getRepository('AppBundle:Produit')->findAll();
         return $this->render('AppBundle:default:index.html.twig', [
             'produits' => $produits
         ]);

     }

    /**
     * @Route("/products", name ="products")
     * @return Response
     */
    public function allProductsAction(){
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('AppBundle:Produit')->findAll();
        return $this->render('AppBundle:default:allProducts.html.twig', [
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/stock", name ="stock")
     * @return Response
     */
    public function allProductsInStockAction(){
        $em       = $this->getDoctrine();
        $produits = $em->getRepository('AppBundle:Produit')->findBy(['inStock' => true]);
        return $this->render("AppBundle:default:stock.html.twig", ['produits' => $produits]);
    }
     /**
   * @Route("/produit/add", name="produit_add")
   */
    public function addProduitAction(Request $request)
    {
      $produit = new Produit();
      $form    = $this->createForm(ProduitType::class,$produit);

      $form->handleRequest($request);

      if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($produit);
          $em->flush();
          $this->addFlash('success', 'The article has been successfully added.');
          return $this->redirectToRoute('homepage');
      }

      return $this->render('AppBundle:default:product.html.twig',
                        array('produitForm' => $form->createView()));
  }

  /**
  * @Route("/produit/edit/{id}", name="produit_edit")
  */
  public function editProduitAction(Request $request,Produit $produit)
  {
      $form    = $this->createForm(ProduitType::class,$produit);

      $form->handleRequest($request);

      if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($produit);
          $em->flush();
          $this->addFlash('success', 'The article has been successfully added.');
          return $this->redirectToRoute('homepage');
      }

      return $this->render('AppBundle:default:product.html.twig',
          array('produitForm' => $form->createView()));
  }
  /**
  * @Route("/produit/supp/{id}", name="produit_supp")
  */
  public function supProduitAction(Request $request,$id)
  {

          $em = $this->getDoctrine()->getManager();
          $produits = $em->getRepository('AppBundle:Produit')->find($id);

          if (null === $produits) {
              echo "produit n'a pas etait trouvé";
              die;
          }

          $em->remove($produits);
          $em->flush();
          return $this->redirectToRoute('homepage');
  }

    /**
     * @Route("/products/{id}/addToStock", name="addToStock")
     * @param Produit $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addToStockAction(Request $request, Produit $produit){

        if( !$produit->isInStock()){
            $produit->setInStock(true);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }
        return $this->redirectToRoute('products');
    }
}
