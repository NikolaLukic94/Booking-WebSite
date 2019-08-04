<?php

namespace App\Controller;
use App\Entity\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextArea;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserController extends AbstractController
{
    /**
     * @Route("/user/all", name="user_index")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => $this->getDoctrine()->getRepository(User::class)
        ]);
    }

    /**
     * @Route("/user/new", name="new_user")
     * Method({"GET"})  
     */
    public function create()
    {
        $user = new User();
        
        $form = $this->createFormBuilder($user)
                     ->add('username', TextType::class, array('attr' => array('class' => 'form-control')))
                     ->add('password', TextArea::class, array('attr' => array('class'=> 'form-control')))
                     ->add('save', SubmitType::class, array('label' => 'Create', 'attr' => array('class'=>'btn btn-primary mt-3') ))
                     ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redicrectToRoute('user_index');
        }

        return $this->render(
            'user/new.html.twig', array('form'=> $form->createView())
        );
    }

    /**
     * @Route("/user/new", name="new_user")
     * Method({"GET","POST"})     
     */
    public function store()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $event->setName('test');
        $event->setPass('Random');

        $entityManager->persit($user);
        //this will actually save it
        $entityManager->flush();

        return new Response('Saves the event with id of'. $user->getId());
    }   

    /**
     * @Route("/user/edit", name="edit_user")
     */
    public function edit(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);   

        $form = $this->createFormBuilder($user)
        			  ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
        			  ->add('body', TextArea::class, array('attr' => array('class'=> 'form-control')))
        			  ->add('save', SubmitType::class, array('label' => 'Update', 'attr' => array('class'=>'btn btn-primary mt-3') ))
        			  ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            return $this->redicrectToRoute('user_index');
        }

        return $this->render(
            'user/edit.html.twig', array('form'=> $form->createView())
        );
    }  

    /**
     * @Route("/user/edit", name="edit_user")
     */
    public function update()
    {

    }

    /**
     * @Route("/article/{id}", name="article_show")
     * Method({"GET","POST"})
     */
    public function show($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        return $this->render('user/show.html.twig', array('article' => $article));
    }

   /**
     * @Route("/user/edit", name="edit_user")
     */
    public function delete()
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);        

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();       

        $response = new Response();
        $response->send();
    }               
}
