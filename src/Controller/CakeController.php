<?php

namespace App\Controller;

use App\Entity\Cake;
use App\Repository\VerrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CakeController extends AbstractController
{
    private $imageFolder = "images/produits/";

    /**
     * @Route("/produits/gateaux/{id<\d+>}", methods="get", name="productGateau")
     */
    public function showCake(Cake $product) {

        return $this->render("product/product.html.twig", [
            'product' => $product,
            'imageFolder' => $this->imageFolder
        ]);
    }

    /**
     * @Route("/produits/gateaux/{id<\d+>}", methods="delete", name="deleteGateau")
     */
    public function deleteCake(Cake $product, EntityManagerInterface $em): Response {

        try {
            $em->remove($product);
            $em->flush();
        } catch(\Doctrine\ORM\ORMException $exception) {
            return new Response('Could not delete this object', Response::HTTP_NOT_FOUND);
        }

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/produits/gateaux/ajouter", name="ajouterProduit", methods={"GET", "POST"})
     */
    public function addCake(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $form = $this->createFormBuilder()
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('price', NumberType::class, ['label' => 'Prix'])
            ->add('image', FileType::class, ['label' => 'Image'])
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

            $produitAjouter = new Cake(
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