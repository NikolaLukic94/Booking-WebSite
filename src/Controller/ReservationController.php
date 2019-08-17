<?php
namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Entity\Reservation;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextArea;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="reservation")
     */
    public function index()
    {
        $addresses = $this->getDoctrine()
                          ->getRepository(Address::class);

        $addressesCityAndState = [];
        foreach ($addresses as $address) {
            array_push($addressesCityAndState[$address->city], $address->$state);
        }        

        return $this->render(
            'reservation/index.html.twig',[
        	'addressesCityAndState' => $addressesCityAndState]);
    }

    /**
     * @Route("/reservation/new", name="new_reservation")
     * Method({"GET","POST"})
     */
    public function create(Request $request)
    {
        $reservation = new Reservation();

        $form = $this->createFormBuilder($reservation)
                     ->add('duration', TextType::class, array('attr' => array('class' => 'form-control')))
                     ->add('starting_from_date', DateType::class, array('attr' => array('class'=> 'form-control')))
                     ->add('until_date', DateType::class, array('attr' => array('class'=> 'form-control')))         
                     ->add('guests_number', TextType::class, array('attr' => array('class'=> 'form-control')))   
                     ->add('note', TextType::class, array('attr' => array('class' => 'form-control')))                                      
                     ->add('save', SubmitType::class, array('label' => 'Create', 'attr' => array('class'=>'btn btn-primary mt-3') ))
                     ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $reservation = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('reservation');
        }

        return $this->render(
            'user/new.html.twig', ['form'=> $form->createView()
        ]);
        return $this->render(
            'reservation/new.html.twig', array('form'=> $form->createView())
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
