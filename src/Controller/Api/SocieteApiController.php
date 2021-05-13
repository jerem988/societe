<?php
// src/Controller/Api/SocieteApiController.php
namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SocieteListTraceRepository;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class SocieteApiController extends AbstractController
{
    /**
     * @Route("/api/societe-trace/{id}", methods={"GET"}, name="api_societe_trace")
     */
    public function getSocieteTrace(int $id, SocieteListTraceRepository $societeListTraceRepository): Response
    {
        $societeTrace = $societeListTraceRepository
            ->find($id);

        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonObject = $serializer->serialize($societeTrace, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }
}