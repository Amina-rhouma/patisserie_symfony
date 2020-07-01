<?php

namespace App\Controller;

use App\Entity\User;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/subscribe", name="app_subscribe", methods={"GET", "POST"})
     */
    public function subscribe(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('firstname', TextType::class, ['label' => 'Prenom'])
            ->add('birthday', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'choice',
                'years' => range(date('Y')-100, date('Y')),
            ])
            ->add('address', TextareaType::class, ['label' => 'Adresse'])
            ->add('email', TextType::class, ['label' => 'Adresse email'])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
            ])
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $birthdayString = $data['birthday']->format(DateTime::RFC850);

            $user = new User();
            $user->setName($data['name']);
            $user->setFirstName($data['firstname']);
            $user->setBirthday($birthdayString);
            $user->setAddress($data['address']);
            $user->setEmail($data['email']);

            $mdpClair = $data['password'];
            $mdpEncoded = $this->passwordEncoder->encodePassword($user, $mdpClair);
            $user->setPassword($mdpEncoded);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('showCakeList');
        }

        return $this->render("security/subscribe.html.twig",[
            'monFormulaire'=> $form->createView()
        ]);
    }

    /**
     * @Route("/connecter", name="app_signin", methods={"GET", "POST"})
     */
    public function signin(): Response {
        return $this->render('security/signin.html.twig');
    }
    /**
     * @Route("/déconnecter", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
    }
}
