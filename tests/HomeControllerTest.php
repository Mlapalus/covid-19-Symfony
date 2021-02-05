<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class HomeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ?Crawler $crawler;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->crawler = $this->client->request('GET','/');
    }

    public function testAccessHomePage()
    {
        $this->assertResponseIsSuccessful();
    }

    public function testNavBarIsPresent()
    {
        $this->assertSelectorTextContains('a','Covid Stats');
    }

    public function testTitleIsPresentOnThePage()
    {
        $this->assertPageTitleContains('Covid!');
    }

    public function testH1IsPresentOnThePage()
    {
        $this->assertSelectorTextContains('h1', 'Les chiffres du COVID-19 en France');
    }

    public function testDataArePresentOnThePage()
    {
        $this->assertNotEquals(500, $this->client->getResponse()->getStatusCode());
    }
}
