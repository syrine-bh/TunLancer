<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UserType;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class Login1Controller extends AbstractController
{

    public function index()
    {
        return $this->render('login/login.html.twig', [
            'controller_name' => 'Login1Controller',
        ]);
    }

    /**
     * @Route("/login", name="connect")
     * @param Request $request

     */
    public function connect(Request $request,  UserPasswordEncoderInterface $encoder,SessionInterface $session)
    {
        $error = "";

        if ($request->isMethod("post")){
            $orm = $this->getDoctrine()->getManager();
            $repo = $orm->getRepository(Users::class);

            $user = $repo->findOneBy(["Email"=>$request->get("email")]);

            if ($user == null){
                $error = "email or password are invalid";
            }

            else {
                $is_valid = $encoder->isPasswordValid($user, $request->get("password"));

                if ($is_valid==true){
                    $session->start();
                    $session->set("userid",$user->getId());
                    if ($user->getRole()=="admin"){
                        return $this->redirectToRoute("dashboard");
                    }else{
                        return $this->redirectToRoute("home");
                    }
                }
                else {
                    $error = "email or password are invalid";
                }
            }


        }


        // get the login error if there is one
        return $this->render('home/index.html.twig', [
            'errors'         => $error,
        ]);}

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
     * @Route("/logout", name="/logout")
     */
    public function logoutAction(SessionInterface $session){


        $session->remove("user");
        return $this->redirectToRoute("connect");
    }
    /**
     * @Route("/recup", name="pass_recup")
     */
    public function recupAction(Request $req  ,MailerInterface $mailer, UserPasswordEncoderInterface $encoder){
        if ($req->isMethod("post")){
            $orm = $this->getDoctrine()->getManager();
            $repo = $orm->getRepository(Users::class);

            $email = $req->get("Email");
            $user= $repo->findOneBy(array("Email"=>$email));

            if ($user != null){
                $password = $this->generateRandomString(8);
                $hash=$encoder->encodePassword($user,$password);
                $email = (new TemplatedEmail())
                    ->from('projetpfe3s@gmail.com')
                    ->to($user->getEmail())

                    ->subject('password change')
                    ->htmlTemplate("login1/Email/email.html.twig")->context([
                        "Nom"=>$user->getEmail(), "Password"=>$password
                    ]);

                $mailer->send($email);


                $user->setPassword($hash);
                $orm->flush();

                return $this->render("login/recupv.html.twig");
            }
            return $this->render("login/recup.html.twig", ["errors"=>"user not found"]);
        }
        return $this->render("login/recup.html.twig", ["errors"=>""]);
    }
    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

