<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class RegistrationController extends Controller
{

    /**
     * @Route("/register", name="registration")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        // create the form user
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        //  handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            // Encode the password
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            //  save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // create a token with the name of our firewall
//            $token = new UsernamePasswordToken(
//                $user,
//                $password,
//                'main',
//                $user->getRoles()
//            );

//            $this->get('security.token_storage')->setToken($token);
//            $this->get('session')->set('_security_main', serialize($token));


            //add a flash message to the view
            $this->addFlash('notice', 'the user is successfully registered');

            // redirect after success registration to the artisan route
            return $this->redirectToRoute('registration');

        }

        // return the view form to page registration
        return $this->render(
            'registration/index.html.twig',
            array('form' => $form->createView())
        );
    }


}