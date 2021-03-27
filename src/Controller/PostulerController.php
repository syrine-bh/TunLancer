<?php

namespace App\Controller;

use App\Entity\Postuler;
use App\Form\AnonceType;
use App\Form\PostulerType;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostulerController extends AbstractController
{
    /**
     * @Route("/postuler", name="postuler")
     */
    public function index(): Response
    {
        return $this->render('postuler/index.html.twig', [
            'controller_name' => 'PostulerController',
        ]);
    }

    /**
     * @Route("/add_p", name="add_p")
     */
    public function postuler(Request $request)
    {
        $postuler=new Postuler();
        $form=$this->createForm(PostulerType::class,$postuler);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file=$form->get('cv')->getData();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
           $postuler->setCv($file);
            /*$postuler->setUserId(1);
            $postuler->setAnnonceId(11);
            $postuler->setEmail("siwarbenkraiem98@gmail.Com");*/
            $em=$this->getDoctrine()->getManager();
            $em->persist($postuler);
            $em->flush();




         }

        return $this->render('postuler/index.html.twig', [
            "form" => $form->createView(),
        ]);
    }
/**
* @Route("/promote/{id}", name="promote_user")
* @param User $id
* @return Response
*
*/
    public function promote($id )
    {

        $genius = $this->getDoctrine()->getRepository(Postuler::class)->find($id);
        $message = (new Swift_Message('Congratulations Email'))
            ->setFrom('tunlancer.coders@gmail.com')
            ->setTo($genius->getEmail());
        $message->setBody(
            '<html>' .
            ' <body>' .
            '  Congrats <img src="' .
            $message->embed(\Swift_Image::fromPath('D:\congrats.jpg')) .
            '" alt="Image" />' .
            '  Votre postulation a ete effectue avec succes' .
            ' </body>' .
            '</html>',
            'text/html');
        $this->get('mailer')->send($message);
        $em = $this->getDoctrine()->getManager();
        $em->persist($genius);
        $em->flush();
        return $this->redirectToRoute('add_postuler');


    }
}
