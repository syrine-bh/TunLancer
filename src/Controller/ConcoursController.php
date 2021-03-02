<?php

namespace App\Controller;

use App\Entity\Concours;
use App\Form\ConcoursType;
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

    /**
     * @return Response
     * @Route ("/concours/list",name="list")
     */
    public function list (){
        $repo=$this->getDoctrine()->getRepository(Concours::class);
        $concours=$repo->findAll();
        return $this->render('concours/list.html.twig',['concours'=>$concours]);
    }







}
