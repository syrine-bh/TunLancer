<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }
    /**
     * @Route("/categorie", name="categorie")
     */
    public function addcategorie(Request $request)
    {
        $categorie=new Categorie();
        $form=$this->createForm(CategoryType::class,$categorie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute("listecategorie");

        }

        return $this->render('categorie/index.html.twig', [
            "form" => $form->createView(),
        ]);

    }

    /**
     * @Route("/listecategorie", name="listecategorie")
     */
    public function get()
    {
        $categorie= $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/List.html.twig', [
            "listecategorie" => $categorie,
        ]);
    }

    /**
     * @Route("/deletcat/{id}", name="deletcat")
     */
    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $categorie= $entityManager->getRepository(Categorie::class)->find($id);
        $entityManager->remove($categorie);
        $entityManager->flush();

        return $this->redirectToRoute("listecategorie");
    }
    /**
     * @Route("/modify_cat/{id}", name="modify_categorie")
     */
    public function modify_categorie(Request $request, int $id)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $categorie= $entityManager->getRepository(Categorie::class)->find($id);
        $form = $this->createForm(CategoryType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
        }




        return $this->render("categorie/Modifier.html.twig", [

            'form' => $form->createView(),
        ]);


    }



}