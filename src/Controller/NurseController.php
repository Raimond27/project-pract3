<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

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

    //  Ruta para obtener TODOS los enfermeros
    #[Route('/nurses', name: 'nurse_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $nurses = $this->loadNurses();

        if (empty($nurses)) {
            return $this->json(['error' => 'No nurses found'], 404);
        }

        return $this->json($nurses);
    }

    //  Ruta para buscar por nombre
    #[Route('/nurse/find/{name}', name: 'nurse_find_by_name', methods: ['GET'])]
    public function findByName(string $name): JsonResponse
    {
        $nurses = $this->loadNurses();

        foreach ($nurses as $nurse) {
            if (strcasecmp($nurse['name'], $name) === 0) {
                return $this->json($nurse);
            }
        }

        return $this->json(['error' => 'Nurse not found'], 404);
    }
}
