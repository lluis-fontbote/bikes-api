<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BikeTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    private HttpClientInterface $client;

    protected function setUp(): void
    {
        $this->client = $this->createClient();
    }

    public function testCreateBikeValidData(): void
    {
        $this->client->request('POST', '/api/bikes', [
            'headers' => ['Content-Type' => 'application/ld+json'],
            'json' => [
                'model' => 'CBR600RR',
                'cylinderCapacity' => 600,
                'brand' => 'Honda',
                'type' => 'custom',
                'weight' => 195,
                'extras' => ['ABS', 'control de tracción', 'iluminación LED'],
                'limitedEdition' => false,
            ]
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }

}
