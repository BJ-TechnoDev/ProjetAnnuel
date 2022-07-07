<?php

namespace App\Controller;

use App\Controller\Admin\ContratCrudController;
use App\Entity\Contrat;
use App\Service\ContratService;
use App\Service\CsvService;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Factory\FilterFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ContratRequest
{
    #[Route('contrat-request/{contratRequest}', name: 'app_csv_export_contrat_request')]
    #[ParamConverter("contratRequest", class: Contrat::class)]

    public function contrat_request_export(Contrat $contrat, CsvService $csvService) {
        $response = new Response($csvService->export());
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment');

        return $response;
    }
}