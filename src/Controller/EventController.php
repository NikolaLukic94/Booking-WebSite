<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class EventController extends AbstractController
{
    /**
     * @Route("/")
     * Method({"GET","POST"})
     */
    public function index()
    {
        $number = "3";

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}

