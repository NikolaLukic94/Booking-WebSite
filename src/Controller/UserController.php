<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserController extends AbstractController
{
    /**
     * @Route("/users/all", name="user_index")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'users' => $this->getDoctrine()->getRepository(User::class)->findAll()
        ]);
    }

    /**
     * @Route("/users/new", name="new_user")
     * Method({"GET","POST"})  
     */
    public function create(Request $request)
    {
        $user = new User;

        $form = $this->createFormBuilder($user)
                     ->add('username', TextType::class, array('attr' => array('class' => 'form-control'))) 
                     ->add('first_name', TextType::class, array('attr' => array('class' => 'form-control'))) 
                     ->add('last_name', TextType::class, array('attr' => array('class' => 'form-control')))                                   
                     ->add('email', TextType::class, array('attr' => array('class' => 'form-control')))
                     ->add('password', TextType::class, array('attr' => array('class'=> 'form-control')))
                     ->add('save', SubmitType::class, array('label' => 'Create', 'attr' => array('class'=>'btn btn-primary mt-3') ))
                     ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();   
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render(
            'user/new.html.twig', ['form'=> $form->createView()
        ]);

    }

    /**
     * @Route("/users/edit", name="edit_user")
     */
    public function edit(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);   

        $form = $this->createFormBuilder($user)
        			  ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
        			  ->add('body', TextType::class, array('attr' => array('class'=> 'form-control')))
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
     * @Route("/users/edit", name="edit_user")
     */
    public function update()
    {

    }

   /**
     * @Route("/users/delete/{id}", name="delete_user")
     */
    public function delete(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);        

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();       

        return $this->redirectToRoute('user_index');
    }               
}
