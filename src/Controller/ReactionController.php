<?php

namespace App\Controller;

use App\Entity\Reaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReactionController extends AbstractController
{
    /**
     * @Route("/reaction", name="reaction")
     */
    public function index(): Response
    {
        return $this->render('reaction/index.html.twig', [
            'controller_name' => 'ReactionController',
        ]);
    }
}