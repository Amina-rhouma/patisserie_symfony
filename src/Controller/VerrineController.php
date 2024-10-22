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

    /**
     * @Route("/produits/verrines/{id<\d+>}", methods="delete", name="deleteVerrine")
     */
    public function deleteVerrine(Verrine $verrine, EntityManagerInterface $em): Response {
        $this->denyAccessUnlessGranted(ProductAuthorization::DELETE_PRODUCT, $verrine);

        try {
            $em->remove($verrine);
            $em->flush();
        } catch(\Doctrine\ORM\ORMException $exception) {
            return new Response('Could not delete this object', Response::HTTP_NOT_FOUND);
        }

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/produits/verrines/{id<\d+>}/modifier", methods={"GET", "POST"}, name="updateVerrine")
     */
    public function updateVerrine(Verrine $verrine, Request $request, EntityManagerInterface $em, SluggerInterface $slugger) {
        $this->denyAccessUnlessGranted(ProductAuthorization::EDIT_PRODUCT, $verrine);

        $form = $this->createFormBuilder()
            ->add('title', TextType::class, ['data' => $verrine->getTitle()])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'data' => $verrine->getDescription()
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
                'data' => $verrine->getPrice()
            ])
            ->add('image', FileType::class, ['label' => 'Image'])
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

            $verrine->setTitle($data['title']);
            $verrine->setPrice($data['price']);
            $verrine->setDescription($data['description']);
            $verrine->setImage($newFilename);

            $em->flush();

            return $this->redirectToRoute("productGateau", ['id' => $verrine->getId()]);

        }

        return $this->render("product/productUpdateForm.html.twig",[
            'monFormulaire'=> $form->createView(),
            'imageFolder' => $this->imageFolder,
            'oldImage' => $verrine->getImage()
        ]);
    }


}