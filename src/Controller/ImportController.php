<?php

namespace App\Controller;

use App\Service\CsvImporter;
use App\Service\ValidationEngine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ImportController extends AbstractController
{
    #[Route('/import', name: 'import')]
    public function index(Request $request, CsvImporter $importer, ValidationEngine $engine): Response
    {
        $message = null;

        if ($request->isMethod('POST')) {
            $file = $request->files->get('csv_file');
            if ($file) {
                $imported = $importer->import($file->getPathname());
                $exceptions = $engine->runAll();
                $message = "Imported $imported records. Found $exceptions exceptions.";
            }
        }

        return $this->render('import/index.html.twig', [
            'message' => $message,
        ]);
    }
}