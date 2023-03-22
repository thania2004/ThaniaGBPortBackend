<?php

namespace App\Controller;

use App\Entity\Backend;
use App\Form\BackendType;
use App\Repository\BackendRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/apibackend')]
class ApiController extends AbstractController
{
    #[Route('/list', name: 'app_apibackend_index', methods: ['GET'])]
    public function index(BackendRepository $backendRepository): Response
    {
        $backend = $backendRepository->findAll();

        $data = [];

        foreach ($backend as $p) {
            $data[] = [
                'id' => $p->getId(),
                'name' => $p->getName(),
                'description' => $p->getDescription(),
                'image' => $p->getImage(),
                'link' => $p->getLink(),
            ];
            
        }

        //dump($data);die; 
        //return $this->json($data);
        return $this->json($data, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }
}