<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\Experience;
use App\Entity\Experiences;
use App\Entity\Formation;
use App\Entity\Users;
use App\Form\UserType;
use App\Repository\UsersRepository;
use Knp\Component\Pager\PaginatorInterface;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(): Response
    {
        $orm = $this->getDoctrine()->getManager();
        $us = $orm->getRepository(Users::class)->find(17);


        return $this->render('profil/profil.html.twig', [
            'controller_name' => 'ProfilController', "user" => $us
        ]);
    }


    public function afficheexperienceAction()
    {
        $em = $this->getDoctrine()->getManager();

        $competence = $em->getRepository(Competence::class)->findAll();

        return $this->render('profil/afficheexperience.html.twig', array(
            'competence' => $competence,
        ));
    }

    public function afficheformationAction()
    {
        $em = $this->getDoctrine()->getManager();

        $formation = $em->getRepository(Formation::class)->findAll();

        return $this->render('profil/afficheformation.html.twig', array(
            'formation' => $formation,
        ));
    }
    public function afficheexperience1Action()
    {
        $em = $this->getDoctrine()->getManager();

        $experiences = $em->getRepository(Experiences::class)->findAll();

        return $this->render('profil/afficheexperience1.html.twig', array(
            'experiences' => $experiences,
        ));
    }
    /**
     * @Route("/modify/{id}",name="modifier")
     * */
    public function editUser(Users $user, Request $request, int $id)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->add('Submit', SubmitType::class, array('label' => 'Modifier'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(users::class)->find($id);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message', 'Utlisateur modifié avec succès');
            return $this->redirectToRoute("profil");
        }
        return $this->render('editprofil.html.twig', [
            'form' => $form->createView(),]);

    }
/*
    /**
     * @Route("/hireme", name="hire")
     * @param $Nom
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    /*
    public function hire ( $Nom, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message ('Hello Email'))
            ->setFrom('projetpfe3s@gmail.com')
            ->setTo('rihab.haddad@esprit.tn')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'profil/registration.html.twig',
                    ['Nom' => $Nom]
                ),
                'text/html'
            )

            // you can remove the following code if you don't define a text version for your emails
            ->addPart(
                $this->renderView(
                // templates/emails/registration.txt.twig
                    'profil/registration.txt.twig',
                    ['Nom' => $Nom]
                ),
                'text/plain'
            )
        ;

        $mailer->send($message);

        return $this->render('profil/profil.html.twig');
    }
    */

}








