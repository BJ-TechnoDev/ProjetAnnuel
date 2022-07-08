<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Service\CsvService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ContratRequest
{
    #[Route('contrat/{id}', name: 'app_csv_export_contrat_request')]
    #[ParamConverter("exportContrat", class: Contrat::class)]
    public function exportContrat(Contrat $contrat, CsvService $csvService)
    {
        $response = new Response($csvService->export($contrat, 'export_cas_contrat_'));
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment');

        return $response;
    }
}