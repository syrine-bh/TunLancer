<?php

namespace App\Controller;


use App\Entity\Formation;
use App\Entity\Users;


use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Response;


class UserController extends AbstractController
{


    /**
     * @Route("/list", name="list")
     * @param UsersRepository $users
     * @param $paginator
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(UsersRepository $users, PaginatorInterface $paginator, request $request)
    {
        $donnees = $this->getDoctrine()->getManager()->getRepository(Users::class)->findAll();
        $users = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            7);
        return $this->render('data-tables.html.twig', array(
            'users' => $users,
        ));
    }


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
            $hash = $encoder->encodePassword($user, $user->getPassword());
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
            $user = $entityManager->getRepository(users::class)->find($id);
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
            $user = $em->getRepository(users::class)->find($id);

            if (!$user) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute("list");
    }


/*
    /**
     * @Route("/searchuser", name="searchuser)
     */

/*
    public function searchusers(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(users::class);
        $requestString = $request->get('searchValue');
        $users = $repository->findUserByName($requestString);
//        $jsonContent = $Normalizer->normalize($users, 'json', ['groups' => 'users']);
//        $retour = json_encode($jsonContent);
//        return new Response($retour);
        return $this->render('data-tables.html.twig',['users'=>$users]);

    }
*/

    /**
     * @param Request $request
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     * @Route("searchuser", name="search")
     */

    public function searchuser(Request $request, NormalizerInterface $normalizer){
        $repository = $this->getDoctrine()->getRepository(users::class);
        $requestString=$request->get('searchValue');

        $users = $repository->findUserByName($requestString);

        return $this->render("userr.html.twig",
            ['users'=>$users]);
    }




    /*
        /**
         * @Route("/permute/enabled", name="back_user_permute_enabled", methods="GET")
         */
    /*/  public function permuteEnabled(Request $request): Response
      {
          $users = $this->userManager->getUsers();
          $this->denyAccessUnlessGranted('back_user_permute_enabled', $users);
          foreach ($users as $user) {
              $permute = $user->getEnabled() ? false : true;
              $user->setEnabled($permute);
          }
          $this->getDoctrine()->getManager()->flush();

          return $this->redirectToRoute('');
      } */
}





