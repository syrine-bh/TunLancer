<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Repository\ParticipationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Entity\Concour;

use App\Entity\Formation;
use App\Entity\Users;


use App\Repository\UsersRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Knp\Component\Pager\PaginatorInterface;



class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route ("/concour/listParticipants/{id}",name="listParticipants")
     */
    public function getPart(Concour $concour, ParticipationRepository  $rep )
    {
        $test=$rep->FindByConcId($concour->getId());
        return $this->render('admin/concour/listParticipants.html.twig',['participant'=>$test]);

    }

    /**
     * @Route ("/concour/listTTParticipants",name="listTTParticipants")
     */
    public function getTTPart( ParticipationRepository  $rep )
    {
        $test=$rep->findAll();
        return $this->render('participation/listTTParticipants.html.twig',['participation'=>$test]);

    }


//    /**
//     * @Route("/list", name="list")
//     * @param UsersRepository $users
//     * @param $paginator
//     * @param $request
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function listAction(UsersRepository $users, PaginatorInterface $paginator,request  $request)
//    {
//        $donnees = $this->getDoctrine()->getManager()->getRepository(Users::class)->findAll();
//        $users = $paginator->paginate(
//            $donnees, // Requête contenant les données à paginer (ici nos articles)
//            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
//            7 );
//        return $this->render('data-tables.html.twig', array(
//            'users' => $users,
//        ));
//    }


    public function afficheuserAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(Users::class)->findAll();

        return $this->render('profil/user.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * @Route("/adduser", name="adduser")
     * @param Request $request

     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add_userAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new Users();
        $form = $this->createForm(UserType::class, $user);
        $form->add('Submit', SubmitType::class, array('label' => 'Sign up'));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash=$encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home', array('id' => $user->getId()));
        }


        return $this->render('login/Registration.html.twig', [

            'form' => $form->createView(),
        ]);
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
            $user = $entityManager->getRepository(Users::class)->find($id);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message', 'Utlisateur modifié avec succès');
            return $this->redirectToRoute("list");
        }
        return $this->render('edit_user.html.twig', [
            'form' => $form->createView(),]);

    }

    /**
     * @Route("/delete/{id}",name="deleteuser")
     * @param $id
     */
    public function deleteAction($id)
    {

        {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(Users::class)->find($id);

            if (!$user) {
                throw $this->createNotFoundException('Unable to find Users entity.');
            }

            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute("list");
    }
    /**
     * @Route("/permute/enabled", name="back_user_permute_enabled", methods="GET")
     */
    public function permuteEnabled(Request $request): Response
    {
        $users = $this->userManager->getUsers();
        $this->denyAccessUnlessGranted('back_user_permute_enabled', $users);
        foreach ($users as $user) {
            $permute = $user->getEnabled() ? false : true;
            $user->setEnabled($permute);
        }
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('');
    }





}
