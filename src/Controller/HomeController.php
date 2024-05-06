<?php

namespace App\Controller;

;

use App\Entity\Car;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'app_home_index')]
    public function index(Request $request): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route(path:'/list', name: 'app_voiture_list')]
    public function show(Request $request , EntityManagerInterface $em): Response
    {
        $voitures = $em->getRepository(Car::class)->findAll();

        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    #[Route(path:'/show-{id}', name: 'app_voiture_show')]
    public function list(Request $request , int $id , CarRepository $carRepository): Response
    {
        $car = $carRepository->find($id);
        if(!$car){
            return $this->redirectToRoute('app_home_index');
        }
        return $this->render('home/show.html.twig',[
            'car' => $car
        ]);
    }
}