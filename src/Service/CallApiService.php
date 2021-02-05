<?php


namespace App\Service;


use PHPUnit\Exception;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        //$this->client = $client;
        $this->client = new CurlHttpClient();
    }
    public function getFranceData(): array
    {
     return $this->getApi('FranceLiveGlobalData');
    }

    public function getAllData(): array
    {
        return $this->getApi('AllLiveData');
    }

    public function getDepartmentData(string $department)
    {
        return $this->getApi('LiveDataByDepartement?Departement=' . $department);
    }

    public function getAllDataByDate($date):array
    {
        return $this->getApi('AllDataByDate?date='.$date);
    }

    private function getApi(string $option)
    {
        try {
            $response = $this->client->request(
                'GET',
                'https://coronavirusapi-france.now.sh/' . $option
            );
            return $response->toArray();
        }catch (ClientExceptionInterface $e) {
        } catch (DecodingExceptionInterface $e) {
        } catch (RedirectionExceptionInterface $e) {
        } catch (ServerExceptionInterface $e) {
        } catch (TransportExceptionInterface $e) {
        }
    }

    public function getWorld()
    {
            $response = $this->client->request(
                'GET',
                'https://api.covid19api.com/summary'
            );
            return $response->toArray();
    }

}