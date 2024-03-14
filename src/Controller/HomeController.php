<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {

        $menus = [
            [
                'image' => 'images/image9.jpg',
                'name' => 'Menu 1',
                'price' => 'price',
                'description' => 'Description du menu 1.',
                //'link' => '#'
            ],
            
        ];

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'menus' => $menus,
        ]);
    }
}
