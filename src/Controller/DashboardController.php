<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(Connection $connection): Response
    {
        $total = $connection->fetchOne('SELECT COUNT(*) FROM records');
        $exceptionCount = $connection->fetchOne('SELECT COUNT(*) FROM exceptions');
        $exceptions = $connection->fetchAllAssociative(
            'SELECT e.*, r.patient_id, r.provider_name, r.service_date, r.claim_type
             FROM exceptions e
             JOIN records r ON e.record_db_id = r.id
             ORDER BY e.created_at DESC'
        );

        $byRule = $connection->fetchAllAssociative(
            'SELECT rule_name, COUNT(*) as cnt FROM exceptions GROUP BY rule_name'
        );

        return $this->render('dashboard/index.html.twig', [
            'total'          => $total,
            'exceptionCount' => $exceptionCount,
            'exceptions'     => $exceptions,
            'byRule'         => $byRule,
        ]);
    }
}