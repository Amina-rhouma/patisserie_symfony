<?php

namespace App\Controller;


use App\Entity\Product;
use App\Repository\ProductRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductCakeListController extends AbstractController
{
    private $imageFolder = "images/produits/";

    /**
     * @Route("/produits/gateaux", name="showCakeList")
     */
   public function showProductList(ProductRepository $repo): Response
   {
       $data = $repo->findAll();

       return $this->render("product/productCakeList.html.twig", [
           'cakeList' => $data,
           'imageFolder' => $this->imageFolder
       ]);
   }
    /**
     * @Route("/produits/gateaux/ajouter", name="ajouterProduit", methods={"GET", "POST"})
     */
   public function addProduct(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
   {
       $form = $this->createFormBuilder()
           ->add('title', TextType::class, ['label' => 'Titre'])
           ->add('description', TextareaType::class, ['label' => 'Description'])
           ->add('price', NumberType::class, ['label' => 'Prix'])
           ->add('image', FileType::class, ['label' => 'Image'])
           ->add('submit', SubmitType::class, ['label' => 'Ajouter'])
           ->getForm()
       ;
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid())
       {
           $data = $form->getData();
           /** @var UploadedFile $file */
           $file = $data['image'];
           $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
           $safeFilename = $slugger->slug($originalFilename);
           $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

           try {
               $file->move(
                   $this->getParameter('images_folder'),
                   $newFilename
               );
           } catch (FileException $e) {
               dd($e);
           }

           $produitAjouter = new Product(
               $data['title'],
               $data['price'],
               $data['description'],
               $newFilename
           );

           $em->persist($produitAjouter);
           $em->flush();

           return $this->redirectToRoute('showCakeList');
       }
       return $this->render("product/addProducts.html.twig",[
           'monFormulaire'=> $form->createView()
       ]);
   }

}
