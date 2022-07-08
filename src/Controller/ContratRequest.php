<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Service\CsvService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ContratRequest
{
    #[Route('contrat-request/{contratRequest}', name: 'app_csv_export_contrat_request')]
    #[ParamConverter("contratRequest", class: Contrat::class)]

    public function contrat_request_export(Contrat $contrat, CsvService $csvService) {
        $response = new Response($csvService->export($contrat, 'test'));
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment');

        return $response;
    }
}