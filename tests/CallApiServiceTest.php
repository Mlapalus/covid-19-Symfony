<?php

namespace App\Tests;

use App\Service\CallApiService;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Psr18Client;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

class MyClient implements HttpClientInterface
{
    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $client = HttpClient::create();
        return $client->request($method,$url,$options);
    }

    public function stream($responses, float $timeout = null): ResponseStreamInterface
    {
        // TODO: Implement stream() method.
    }
}

class CallApiServiceTest extends TestCase
{
    private CallApiService $callApiService;

    public function setUp(): void
    {
        parent::setUp();
        $this->callApiService = new CallApiService(new MyClient());
    }

    public function testItShouldReturnAArray()
    {
        $this->assertIsArray($this->callApiService->getFranceData(),"It doesn't return a array");
    }

    public function testItShouldBeReturnFranceGlobalLiveData()
    {
        $this->assertArrayHasKey('FranceGlobalLiveData', $this->callApiService->getFranceData());
    }
}
