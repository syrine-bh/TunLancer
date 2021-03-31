<?php

namespace App\Controller;



use App\Entity\Competence;
use App\Form\CompetenceType;
use App\Repository\CompetenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CompetencesController extends AbstractController
{
    /**
     * @Route("/competence/list", name="listcom")
     * @param CompetenceRepository $Competence
     * @return Response
     */
    public function indexAction(CompetenceRepository $Competence)
    {

        return $this->render('profil/profil.html.twig', array(
            'competence' => $Competence->findAll(),
        ));
    }

    /**
     * @Route("/competence/add", name="competence")
     * @param Request $request
     * @param SessionInterface $session

     * @return Response
     */
    public function add_competenceAction(Request $request, SessionInterface $session) : Response
    {
        if ($session->get("user")) {

                $competence = new Competence();
                $form = $this->createForm(CompetenceType::class, $competence);
                $form->add('submit', SubmitType::class, array('label' => 'Add'));
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($competence);
                    $entityManager->flush();
                    return $this->redirectToRoute('profil', array('id' => $competence->getId()));
                }
                return $this->render('profil/add_com.html.twig', [
                    '$competence' => $competence,
                    'form' => $form->createView(),
                ]);
            }

    }

    /**
     * @Route("/modify_com/{id}",name="modifierc")
     * @param Request $request
     * @param int $id
     * @param Competence $competence
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editCom(Request $request, int $id, competence $competence)
    {
        $form = $this->createForm(CompetenceType::class, $competence);
        $form->add('modifier', SubmitType::class, array('label' => 'Modifier'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $competence= $entityManager->getRepository(Competence::class)->find($id);
            $entityManager->persist($competence);
            $entityManager->flush();
            $this->addFlash('message', 'competence modifié avec succès');
            return $this->redirectToRoute("profil");
        }
        return $this->render('profil/editcom.html.twig',[
            'form'=>$form->createView(), 'id'=>$id, "competence"=>$competence]);

    }

    /**
     * @Route("competence/delete/{id}",name="deletecom")
     * @param $id
     */
    public function deleteAction($id)
    {

        {     $em = $this->getDoctrine()->getManager();
            $competence = $em->getRepository(competence::class)->find($id);

            if (!$competence) {
                throw $this->createNotFoundException('Unable to find competence entity.');
            }

            $em->remove($competence);
            $em->flush();
        }

        return $this->redirectToRoute("profil");}







}
