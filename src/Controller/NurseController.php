<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
#[Route('/nurse')]
final class NurseController extends AbstractController
{
    private function loadNurses(): array
    {
        $filePath = $this->getParameter('kernel.project_dir') . '/public/nurse.json';

        if (!file_exists($filePath)) {
            return [];
        }

        $data = json_decode(file_get_contents($filePath), true);

        return $data ?? [];
    }



    //  Ruta para buscar por nombre
    #[Route('/name/{name}', name: 'nurse_find_by_name', methods: ['GET'])]
    public function findByName(string $name): JsonResponse
    {
        $nurses = $this->loadNurses();

        foreach ($nurses as $nurse) {
            if (strcasecmp($nurse['name'], $name) === 0) {
                return $this->json($nurse);
            }
        }

        return $this->json(['error' => 'Nurse not found'], Response::HTTP_FOUND);
    }
}
