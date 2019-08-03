<?php 

namespace App\Controller;

use App\Entity\Event;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextArea;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_list")
     * Method({"GET","POST"})
     */
    public function index()
    {

        return $this->render(
            'events/index.html.twig');
    }

    /**
     * @Route("/event/new", name="new_event")
     * Method({"GET","POST"})
     */
    public function create(Request $request)
    {
        $event = new Event();
        
        $form = $this->createFormBuilder($event)
                     ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
                     ->add('body', TextArea::class, array('attr' => array('class'=> 'form-control')))
                     ->add('save', SubmitType::class, array('label' => 'Create', 'attr' => array('class'=>'btn btn-primary mt-3') ))
                     ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redicrectToRoute('article_list');
        }

        return $this->render(
            'articles/new.html.twig', array('form'=> $form->createView())
        );
    }

    /**
     * @Route("/event/edit/{id}", name="edit_event")
     * Method({"GET","POST"})
     */
    public function edit(Request $request, $id)
    {
        $event = $this->getDoctrine()->getRepository(Article::class)->find($id);   

        $form = $this->createFormBuilder($event)->add('name', TextType::class, array('attr' => array('class' => 'form-control')))->add('body', TextArea::class, array('attr' => array('class'=> 'form-control')))->add('save', SubmitType::class, array('label' => 'Update', 'attr' => array('class'=>'btn btn-primary mt-3') ))->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            return $this->redicrectToRoute('article_list');
        }

        return $this->render(
            'articles/edit.html.twig', array('form'=> $form->createView())
        );
    }

    /**
     * @Route("/article/{id}", name="article_show")
     * Method({"GET","POST"})
     */
    public function show($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        return $this->render('events/show.html.twig', array('article' => $article));
    }



    /**
     * @Route("/")
     */
    public function save()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $event = new Event();
        $event->setName('Event One');
        $event->setDesc('Random test desc');

        $entityManager->persit($article);
        //this will actually save it
        $entityManager->flush();

        return new Response('Saves the event with id of'. $event->getId());
    }  

    /**
     * @Route("/event/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {

        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);        

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($event);
        $entityManager->flush();       

        $response = new Response();
        $response->send();
    }  

}

