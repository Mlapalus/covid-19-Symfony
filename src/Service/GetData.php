<?php


namespace App\Service;


use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class GetData
{
    private CallApiService $callApiService;

    /**
     * GetData constructor.
     * @param $callApiService
     */
    public function __construct(CallApiService $callApiService)
    {
        $this->callApiService = $callApiService;
    }

    public function getFranceData()
    {
       return $this->callApiService->getFranceData();
    }

    public function getAllData()
    {
        return $this->callApiService->getAllData();
    }

    public function getDepartmentData(string $department)
    {
        return $this->callApiService->getDepartmentData($department);
    }

    public function getAllDataByDate(
        string $department,
        ChartBuilderInterface $chartBuilder)
    {
        $label = [];
        $hospitalisation = [];
        $rea = [];

        for ($i=1; $i < 8; $i++) {
            $date = New \DateTime('- '. $i .' day');
            $datas = $this->callApiService->getAllDataByDate($date->format('Y-m-d'));

            foreach ($datas['allFranceDataByDate'] as $data) {
                if( $data['nom'] === $department) {
                    $label[] = $data['date'];
                    $hospitalisation[] = $data['nouvellesHospitalisations'];
                    $rea[] = $data['nouvellesReanimations'];
                    break;
                }
            }
        }
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => array_reverse($label),
            'datasets' => [
                [
                    'label' => 'Nouvelles Hospitalisations',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'data' => array_reverse($hospitalisation),
                ],
                [
                    'label' => 'Nouvelles entrées en Réa',
                    'borderColor' => 'rgb(46, 41, 78)',
                    'backgroundColor' => '9999',
                    'data' => array_reverse($rea),
                ],
            ],
        ]);

        $chart->setOptions([/* ... */]);

        return $chart;
    }

    public function getWorldData()
    {
        return $this->getWorldData();
    }
}