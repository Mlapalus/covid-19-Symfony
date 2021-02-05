<?php

namespace App\Controller;

use App\Service\GetData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class HomeController extends AbstractController
{
    private GetData $getData;

    public function __construct(GetData $getData)
    {
        $this->getData = $getData;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'titleH1' => 'Les chiffres du COVID-19 en France',
            'title' => 'Covid!',
            'data' => $this->getData->getFranceData()
        ]);
    }

    /**
     * @Route("/departements", name="departments")
     */
    public function departments(): Response
    {
        return $this->render('home/departments.html.twig', [
            'titleH1' => 'Les chiffres du COVID-19 en France',
            'title' => 'Covid!',
            'departments' => $this->getData->getAllData()
        ]);
    }

    /**
     * @Route("/departement/{department}", name="one_department")
     */
    public function departmentData(
        string $department,
        ChartBuilderInterface $chartBuilder
    ): Response
    {
        $data =  $this->getData->getDepartmentData($department);
        $chart = $this->getData->getAllDataByDate($department, $chartBuilder);
        return $this->render('home/department.html.twig', [
            'titleH1' => 'Les chiffres du COVID-19 en France',
            'title' => 'Covid!',
            'chart' => $chart,
            'data' => $data
        ]);
    }


}
