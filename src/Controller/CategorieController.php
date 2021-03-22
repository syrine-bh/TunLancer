<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

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
    public function getlist(Request $request, PaginatorInterface $paginator)
    {
        $donnees= $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findBy([],['id' => 'desc']);
        $categorie = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );




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

    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Categorie::class);
        $requestString=$request->get('searchValue');
        $annonces = $repository->findBynom($requestString);
        $jsonContent = $Normalizer->normalize($annonces, 'json',['groups'=>'post:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }



}