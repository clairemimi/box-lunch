<?php

namespace App\Controller;
use App\Controller\Menu;
use App\Controller\MenuType;
use App\Repository\MenuRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(
        MenuRepository $menuRepo,
        UserRepository $userRepo,
        OrderRepository $orderRepo
    ): Response
    {


        //ici c'est la page d'admin
        $menus = $menuRepo->findAll();
        $users = $userRepo->findAll();
        $orders =$orderRepo->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'hallo claire',
            'menus' => $menus,
            'users' => $users,
            'orders'=> $orders
        ]);
    }
    #[Route('/create/menu', name: 'admin_create_menu')]
    public function createMenu(Request $request,MenuRepository $menuRepo): Response
    {
            

            // $menu = new Menu();
            // $form = $this->createForm(MenuType::class, $menu);
            // $form->handleRequest($request);
    
            // if ($form->isSubmitted() && $form->isValid()) {
            //     // Handle form submission and save the new menu to the database
            //     $menuRepository = $this->getDoctrine()->getRepository(Menu::class);
            //     $menuRepository->add($menu, true);
            
            //     // Redirect to the admin page after the menu has been created
            //     return $this->redirectToRoute('admin');
            // }
            
            // return $this->render('admin/create_menu.html.twig', [
            //     'form' => $form->createView(),
            // ]);
    
            //     // Sauvegardez le menu dans la base de données
            //     $entityManager = $this->getDoctrine()->getManager();
            //     $entityManager->persist($menu);
            //     $entityManager->flush();
    
            //     return $this->redirectToRoute('home'); // Redirigez vers la page home
            
    
        
        //afficher un formulaire de ceération de menu 
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'hallo claire',
        ]);
    }


}
