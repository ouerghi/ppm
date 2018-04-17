<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SurveyController extends Controller
{
    /**
     * @Route("/survey", name="survey")
     */
    public function index()
    {
       return $this->render('survey/index.html.twig');
    }
}
