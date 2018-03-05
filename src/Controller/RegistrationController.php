<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegistrationController extends Controller
{
    /**
     * @Route("/registration", name="registration")
     */
    public function index()
    {
        return $this->render('Registration/index.html.twig');
    }
}
