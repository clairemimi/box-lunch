<?php

namespace App\Controller;

use App\Entity\DeliveryMethod;
use App\Form\DeliveryMethodType;
use App\Repository\DeliveryMethodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/delivery/method')]
class DeliveryMethodController extends AbstractController
{
    #[Route('/', name: 'app_delivery_method_index', methods: ['GET'])]
    public function index(DeliveryMethodRepository $deliveryMethodRepository): Response
    {
        return $this->render('delivery_method/index.html.twig', [
            'delivery_methods' => $deliveryMethodRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_delivery_method_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $deliveryMethod = new DeliveryMethod();
        $form = $this->createForm(DeliveryMethodType::class, $deliveryMethod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($deliveryMethod);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Le mode liverison a été créer avec succès.'
            );



            return $this->redirectToRoute('app_delivery_method_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('delivery_method/new.html.twig', [
            'delivery_method' => $deliveryMethod,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_delivery_method_show', methods: ['GET'])]
    public function show(DeliveryMethod $deliveryMethod): Response
    {
        return $this->render('delivery_method/show.html.twig', [
            'delivery_method' => $deliveryMethod,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_delivery_method_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DeliveryMethod $deliveryMethod, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DeliveryMethodType::class, $deliveryMethod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Le mode livraison a été bien modifié.'
            );



            return $this->redirectToRoute('app_delivery_method_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('delivery_method/edit.html.twig', [
            'delivery_method' => $deliveryMethod,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_delivery_method_delete', methods: ['POST'])]
    public function delete(Request $request, DeliveryMethod $deliveryMethod, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deliveryMethod->getId(), $request->request->get('_token'))) {
            $entityManager->remove($deliveryMethod);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_delivery_method_index', [], Response::HTTP_SEE_OTHER);
    }
}
