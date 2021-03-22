<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnonceType;
use App\Repository\AnnonceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

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
            return $this->redirectToRoute('liste');
        }
        return $this->render('annonce/add.html.twig', [
            "form" => $form->createView(),
        ]);

    }
    /**
     * @Route("/liste", name="liste")
     */
    public function getAll(Request $request, PaginatorInterface $paginator)
    {
        $donne = $this->getDoctrine()->getManager()->getRepository(Annonce::class)->findBy([],['id' => 'desc']);
        $annonce = $paginator->paginate(
            $donne,
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('Annonce/test.html.twig', [
            "list" => $annonce,
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(int $id,Request $request,NormalizerInterface $Normalizer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $annonce= $entityManager->getRepository(Annonce::class)->find($id);
        $entityManager->remove( $annonce);
        $entityManager->flush();
       $json=$Normalizer->normalize($annonce,'json',['groups' => 'post:read']);
        return new Response("operation reussite".json_encode($json));

        //return $this->redirectToRoute("liste");
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

    /**
     * @Route("/searchannonce", name="searchannonce")
     */
    public function searchannonce(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Annonce::class);
        $requestString=$request->get('searchValue');
        $annonces = $repository->findBynom($requestString);
        $jsonContent = $Normalizer->normalize($annonces, 'json',['groups'=>'post:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }

    /**
     * @Route("/list", name="list")
     */
    public function getAnn()
    {
        $annonce  = $this->getDoctrine()->getManager()->getRepository(Annonce::class)->findAll();

        return $this->render('Annonce/lister.html.twig', [
            "list" => $annonce,
        ]);
    }





}
