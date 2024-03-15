<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(MenuRepository $menuRepo): Response
    {
        //recuper tous le menus
         $menus = $menuRepo->findAll();


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'menus' => $menus,
        ]);
    }


    #[Route('/home/{id}', name: 'app_home_detail')]
    public function detail(MenuRepository $menuRepo, int $id): Response
    {
        //récuper le menu par id du menu
         $menu = $menuRepo->find($id);

        return $this->render('home/detail.html.twig', [
            'controller_name' => 'HomeController',
            'menu' => $menu,
        ]);
    }
}
