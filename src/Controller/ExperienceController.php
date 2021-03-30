<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Entity\Experiences;
use App\Form\ExperiencesType;
use App\Form\ExperienceType;
use App\Repository\ExperienceRepository;
use App\Repository\ExperiencesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ExperienceController extends AbstractController
{
    /**
     * @Route("/experience/list", name="list")

     * @return Response
     */
    public function index(ExperiencesRepository $experiences): Response
    {
        return $this->render('profil/profil.html.twig', array(
            'experiences' => $experiences->findAll(),

        ));}


    /**
     * @Route("/experience/add", name="experience")
     */
    public function add_experienceAction(Request $request) : Response
    {
        $experiences = new Experiences();
        $form = $this->createForm(experiencesType::class, $experiences);
        $form->add('submit', SubmitType::class, array('label' => 'Add'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($experiences);
            $entityManager->flush();
            return $this->redirectToRoute('profil', array('id' => $experiences->getId()));
        }
        return $this->render('profil/add_exp.html.twig', [
            '$experiences' => $experiences,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/modify_exp/{id}",name="modifierexp")

     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editExp(experiences $experiences ,Request $request,int $id)
    {
        $form = $this->createForm(ExperienceType::class, $experiences);
        $form->add('modifier', SubmitType::class, array('label' => 'Modifier'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $experiences= $entityManager->getRepository(Experiences::class)->find($id);
            $entityManager->persist($experiences);
            $entityManager->flush();
            $this->addFlash('message', 'competence modifié avec succès');
            return $this->redirectToRoute("list");
        }
        return $this->render('profil/edit_exp.html.twig',[
            'form'=>$form->createView(),"experiences"=>$experiences ]);

    }

    /**
     * @Route("experience/delete/{id}",name="delete_exp")
     * @param $id
     */
    public function deleteAction($id)
    {

        {     $em = $this->getDoctrine()->getManager();
            $experiences = $em->getRepository(experiences::class)->find($id);

            if (!$experiences) {
                throw $this->createNotFoundException('Unable to find experience entity.');
            }

            $em->remove($experiences);
            $em->flush();
        }

        return $this->redirectToRoute("list");}







}


