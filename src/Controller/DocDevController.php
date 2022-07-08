<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocDevController extends AbstractController
{
    #[Route('/docdev', name: 'app_doc_dev')]
    public function index(): Response
    {
        return $this->render('doc_dev/index.html.twig', [
            'controller_name' => 'DocDevController',
        ]);
    }
}
