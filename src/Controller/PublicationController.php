<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{
    /**
     * @Route("/publications/", name="publications")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $publications = $em->getRepository(Publication::class)->findAll();

        return $this->render('publication/index.html.twig', [
            'controller_name' => 'PublicationController',
            'result' => $publications
        ]);
    }

    /**
     * @Route("/publications/Add", name="add_publication")
     */
    public function Add(Request $request): Response
    {
        $publication=new Publication();
        $Form=$this->createForm(PublicationType::class,$publication);
        $Form->handleRequest($request);

        if ($Form->isSubmitted()&&$Form->isValid())/*verifier */
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($publication);
            $em->flush();
            return $this->redirectToRoute('publications');
        }
        return $this->render('publication/AddPublication.html.twig', array(
            'publicationform'=>$Form->createView()
        ));
    }
}
