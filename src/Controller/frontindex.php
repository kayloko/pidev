<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class frontindex extends AbstractController
{
    /**
     * @Route("/template", name="front_index",)
     */
    public function index(): Response
    {
        return $this->render('baseFront.html.twig', [
            'controller_name' => 'frontindex',
        ]);
    }

   
}
