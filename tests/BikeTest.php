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

    public function testCreateBikeInvalidLengths(): void
    {
        $this->client->request('POST', '/api/bikes', [
            'headers' => ['Content-Type' => 'application/ld+json'],
            'json' => [
                'model' => str_repeat('a', 51),
                'cylinderCapacity' => 600,
                'brand' => 'Honda',
                'type' => 'custom',
                'weight' => 195,
                'extras' => ['ABS', 'control de tracción', 'iluminación LED'],
                'limitedEdition' => false,
            ]
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->client->request('POST', '/api/bikes', [
            'headers' => ['Content-Type' => 'application/ld+json'],
            'json' => [
                'model' => 'CBR600RR',
                'cylinderCapacity' => 600,
                'brand' =>  str_repeat('a', 41),
                'type' => 'custom',
                'weight' => 195,
                'extras' => ['ABS', 'control de tracción', 'iluminación LED'],
                'limitedEdition' => false,
            ]
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->client->request('POST', '/api/bikes', [
            'headers' => ['Content-Type' => 'application/ld+json'],
            'json' => [
                'model' => 'CBR600RR',
                'cylinderCapacity' => 600,
                'brand' => 'Honda',
                'type' => 'custom',
                'weight' => 195,
                'extras' => explode(',', str_repeat('a,', 21)),
                'limitedEdition' => false,
            ]
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCannotPatchLimitedEdition(): void
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

        $this->client->request('PATCH', "/api/bikes/1", [
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
            'json' => [
                'limitedEdition' => true,
            ]
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

}
