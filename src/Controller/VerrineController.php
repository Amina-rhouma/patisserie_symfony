<?php

namespace App\Controller;

use App\Entity\Verrine;
use App\Security\ProductAuthorization;
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

class VerrineController extends AbstractController
{
    private $imageFolder = "images/produits/";
    private $iconsFolder = "images/icons/";

    /**
     * @Route("/produits/verrines/{id<\d+>}", methods="get", name="productVerrine")
     */
    public function showVerrineProduct(Verrine $verrine) {
        $likes = $verrine->getLikes()->getValues();
        $likesNumber = count($likes);

        if (isset($likes) && $likesNumber > 0) {
            $sumRatings = 0;
            foreach ($likes as $like) {
                $sumRatings = $sumRatings + $like->getRating();
            }
            $avgRatings = $sumRatings / $likesNumber;
        } else {
            $avgRatings = 0;
        }
        return $this->render("product/product.html.twig", [
            'product' => $verrine,
            'imageFolder' => $this->imageFolder,
            'iconsFolder' => $this->iconsFolder,
            'type' => Verrine::TYPE,
            'avgRatings' => $avgRatings,
            'numRatings' => $likesNumber
        ]);
    }

    /**
     * @Route("/produits/verrines/ajouter", name="ajouterVerrine", methods={"GET", "POST"})
     */
    public function addVerrine(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response {
        $this->denyAccessUnlessGranted(ProductAuthorization::ADD_PRODUCT);

        $form = $this->createFormBuilder()
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('price', NumberType::class, ['label' => 'Prix'])
            ->add('image', FileType::class, ['label' => 'Image'])
            ->getForm()
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
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

            $produitAjouter = new Verrine(
                $data['title'],
                $data['price'],
                $data['description'],
                $newFilename
            );

            $em->persist($produitAjouter);
            $em->flush();

            return $this->redirectToRoute('showVerrineList');
        }
        return $this->render("product/addProducts.html.twig",[
            'monFormulaire'=> $form->createView()
        ]);
    }


}