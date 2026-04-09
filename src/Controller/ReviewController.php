<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReviewController extends AbstractController
{
    #[Route('/review/{id}', name: 'review', methods: ['POST'])]
    public function update(int $id, Request $request, Connection $connection): Response
    {
        $status = $request->request->get('review_status');
        $note   = $request->request->get('note', '');

        $allowed = ['new', 'in_review', 'resolved'];
        if (in_array($status, $allowed)) {
            $connection->update('exceptions', [
                'review_status' => $status,
                'note'          => $note,
            ], ['id' => $id]);
        }

        return $this->redirectToRoute('dashboard');
    }
}