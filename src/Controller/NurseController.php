<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class NurseController extends AbstractController
{
    #[Route('/nurse/find/{name}', name: 'nurse_find_by_name', methods: ['GET'])]
    public function findByName(string $name): JsonResponse
    {
        // Datos simulados (mock)
        $nurses = [
            ['id' => 1, 'name' => 'Ana', 'specialty' => 'Pediatría'],
            ['id' => 2, 'name' => 'Luis', 'specialty' => 'Urgencias'],
            ['id' => 3, 'name' => 'Maria', 'specialty' => 'Geriatría'],
        ];

        // Buscar enfermera por nombre
        foreach ($nurses as $nurse) {
            if (strcasecmp($nurse['name'], $name) === 0) {
                return $this->json($nurse);
            }
        }

        // Si no se encuentra
        return $this->json(['error' => 'Nurse not found'], 404);
    }
}
