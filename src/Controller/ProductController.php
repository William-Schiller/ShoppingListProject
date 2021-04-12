<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller
 * @Route (path="produit/", name="product_")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("", name="product")
     */
    public function Product(Request $request,EntityManagerInterface $entityManager): Response
    {
        $limit=3;
        $product = new Product();
        //creation formulaire pr inserer des produits
        $form=$this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()){
        $entityManager->persist($product);
        $entityManager->flush();
        $this->addFlash('success', 'bien ouej!');
       return $this->redirectToRoute('product_product');
        }
//Affichage de la list des produits
        $id = $request->get('id');
        $listProduct= $entityManager->getRepository(Product::class)->findAll($id);



        return $this->render('product/index.html.twig', [
            'formProduct' => $form->createView(),'listProduct'=> $listProduct]);
    }
}
