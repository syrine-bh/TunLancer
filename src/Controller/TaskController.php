<?php

namespace App\Controller;



use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{

    /**
     * @Route("/task/list", name="tasklist")
     * @param TaskRepository $tasks

     * @return Response
     */

    public function indexAction(TaskRepository  $tasks)
    {

        return $this->render('base.html.twig', array(
            'task' => $tasks->findAll(),

        ));
    }
    /**
     * @Route("/task/add", name="taskadd")
     */
    public function add_taskAction(Request $request) : Response
    {
        $em = $this->getDoctrine()->getManager();

        $Task = new Task();
        $form = $this->createForm(TaskType::class, $Task);
        $form->handleRequest($request);

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        if ($form->isSubmitted() ) {

            // $Task->setUser($user);
            $em->persist($Task);
            $em->flush();

            return $this->redirectToRoute("tasklist");
        }

        return $this->render('add_task.html.twig', [
            'Task' => $Task,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modify_task/{id}",name="modifiertask")
     * @param $Task $Task
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editTask(Task $Task ,Request $request,int $id)
    {
        $form = $this->createForm(TaskType::class, $Task );
        $form->add('modifier', SubmitType::class, array('label' => 'Modifier'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $competence= $entityManager->getRepository(Task ::class)->find($id);
            $entityManager->persist($Task );
            $entityManager->flush();
            $this->addFlash('message', 'competence modifié avec succès');
            return $this->redirectToRoute("taskadd");
        }
        return $this->render('editcom.html.twig',[
            'form'=>$form->createView(), ]);

    }

    /**
     * @Route("task/delete/{id}",name="deletetask")
     * @param $id
     */
    public function deleteAction($id)
    {

        {     $em = $this->getDoctrine()->getManager();
            $Task = $em->getRepository(Task::class)->find($id);

            if (!$Task) {
                throw $this->createNotFoundException('Unable to find task entity.');
            }

            $em->remove($Task);
            $em->flush();
        }

        return $this->redirectToRoute("tasklist");}







}
