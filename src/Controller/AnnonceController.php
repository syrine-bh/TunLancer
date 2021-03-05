<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnonceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce", name="annonce")
     */
    public function index(): Response
    {
        return $this->render('annonce/index.html.twig', [
            'controller_name' => 'AnnonceController',
        ]);
    }

    /**
     * @Route("/annonce", name="annonce")
     */
    public function addAnnonce(Request $request)
    {
        $annonce=new Annonce();
        $form=$this->createForm(AnonceType::class,$annonce);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
           // return $this->redirectToRoute('add');
        }
        return $this->render('annonce/add.html.twig', [
            "form" => $form->createView(),
        ]);

    }
    /**
     * @Route("/liste", name="liste")
     */
    public function getAll()
    {
        $annonce = $this->getDoctrine()->getManager()->getRepository(Annonce::class)->findAll();
        return $this->render('Annonce/Lister.html.twig', [
            "list" => $annonce,
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $annonce= $entityManager->getRepository(Annonce::class)->find($id);
        $entityManager->remove( $annonce);
        $entityManager->flush();

        return $this->redirectToRoute("liste");
    }
    /**
     * @Route("/modify/{id}", name="modify")
     */
    public function modify_annonce(Request $request, int $id)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $annonce = $entityManager->getRepository(Annonce::class)->find($id);
        $form = $this->createForm(AnonceType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
        }



        return $this->render("annonce/Modification.html.twig", [

            'form' => $form->createView(),
        ]);


    }




}
