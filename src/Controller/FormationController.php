<?php

namespace App\Controller;



use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    /**
     * @Route("/formation/list", name="listform")
     * @param FormationRepository $formation
     * @return Response
     */
    public function indexAction(FormationRepository $formation)
    {

        return $this->render('profil/profil.html.twig', array(
            'formation' => $formation->findAll(),
        ));
    }
    /**
     * @Route("/formation/add", name="formation")
     */
    public function add_formationAction(Request $request) : Response
    {
        $formation = new formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->add('submit', SubmitType::class, array('label' => 'Add'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();
            return $this->redirectToRoute('profil', array('id' =>$formation->getId()));
        }
        return $this->render('profil/addform.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modifyform/{id}",name="modifierf")
     * @param Request $request
     * @param int $id
     * @param Formation $formation
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editForm(Request $request, int $id, formation $formation)
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->add('modifier', SubmitType::class, array('label' => 'Modifier'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $competence= $entityManager->getRepository(Formation::class)->find($id);
            $entityManager->persist($competence);
            $entityManager->flush();
            $this->addFlash('message', 'formation modifié avec succès');
            return $this->redirectToRoute("profil");
        }
        return $this->render('profil/editform.html.twig',[
            'form'=>$form->createView(), 'id'=>$id, "formation"=>$formation]);

    }

    /**
     * @Route("formation/delete/{id}",name="deleteform")
     * @param $id
     */
    public function deleteAction($id)
    {

        {     $em = $this->getDoctrine()->getManager();
            $competence = $em->getRepository(formation::class)->find($id);

            if (!$competence) {
                throw $this->createNotFoundException('Unable to find formation entity.');
            }

            $em->remove($competence);
            $em->flush();
        }

        return $this->redirectToRoute("profil");}







}
