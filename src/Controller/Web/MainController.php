<?php
namespace App\Controller\Web;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MainController extends AbstractController
{

    /**
    * @Route("/", name="")
    */
    public function number()
    {
        $number = random_int(0, 100);

        return $this->render('main.html.twig', [
            'number' => $number,
        ]);
    }



}
