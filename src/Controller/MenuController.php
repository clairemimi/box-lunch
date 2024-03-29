<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/menu')]
class MenuController extends AbstractController

{
    #[Route('/', name: 'app_menu_index', methods: ['GET'])]
    public function index(MenuRepository $menuRepository): Response
    
    {
        $menus = [];

        // Passer les menus au modèle Twig pour le rendu
        return $this->render('menu/index.html.twig', [
            'menus' => $menuRepository->findAll(),
            'menus' => $menus,
        ]);
    }

    #[Route('/new', name: 'app_menu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($menu);
            $entityManager->flush();
            $this->addFlash('success', 'Menu creact successfully');

            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('menu/new.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_menu_show', methods: ['GET'])]
    public function show(Menu $menu): Response
    {
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_menu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Menu has been updated');

            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('menu/edit.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_menu_delete', methods: ['POST'])]
    public function delete(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$menu->getId(), $request->request->get('_token'))) {
            $entityManager->remove($menu);
            $entityManager->flush();
            $this->addFlash('success', 'Menu delete successfully');

        }

        return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
    }

    // #[Route('/menu/{image}', name: 'app_menu_image', methods: ['POST'])]
    // public function uploadImage(Request $request): Response
    // {
    //     $image = new Image();
    //     $form = $this->createForm(ImageType::class, $image);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $imageFile = $form->get('imageFile')->getData();
    //         if ($imageFile) {
    //             // Convertir le fichier image en données binaires
    //             $imageData = file_get_contents($imageFile);
    //             $image->setImageData($imageData);

    //             // Enregistrer l'entité image dans la base de données
    //             $entityManager = $this->getDoctrine()->getManager();
    //             $entityManager->persist($image);
    //             $entityManager->flush();

    //             // Rediriger ou afficher un message de réussite
    //         }
    //     }

    //     return $this->render('image/upload.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }
}
