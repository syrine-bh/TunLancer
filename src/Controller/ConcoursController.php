<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcoursController extends AbstractController
{
    /**
     * @Route("/concours", name="concours")
     */
    public function index(): Response
    {
        return $this->render('concours/index.html.twig', [
            'controller_name' => 'ConcoursController',
        ]);
    }
}
