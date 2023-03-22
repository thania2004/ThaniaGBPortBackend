<?php

namespace App\Controller;

use App\Entity\Backend;
use App\Form\BackendType;
use App\Repository\BackendRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backend')]
class BackendController extends AbstractController
{
    #[Route('/', name: 'app_backend_index', methods: ['GET'])]
    public function index(BackendRepository $backendRepository): Response
    {
        return $this->render('backend/index.html.twig', [
            'backends' => $backendRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_backend_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BackendRepository $backendRepository): Response
    {
        $backend = new Backend();
        $form = $this->createForm(BackendType::class, $backend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $backendRepository->save($backend, true);

            return $this->redirectToRoute('app_backend_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/new.html.twig', [
            'backend' => $backend,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backend_show', methods: ['GET'])]
    public function show(Backend $backend): Response
    {
        return $this->render('backend/show.html.twig', [
            'backend' => $backend,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_backend_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Backend $backend, BackendRepository $backendRepository): Response
    {
        $form = $this->createForm(BackendType::class, $backend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $backendRepository->save($backend, true);

            return $this->redirectToRoute('app_backend_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/edit.html.twig', [
            'backend' => $backend,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backend_delete', methods: ['POST'])]
    public function delete(Request $request, Backend $backend, BackendRepository $backendRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$backend->getId(), $request->request->get('_token'))) {
            $backendRepository->remove($backend, true);
        }

        return $this->redirectToRoute('app_backend_index', [], Response::HTTP_SEE_OTHER);
    }
}
