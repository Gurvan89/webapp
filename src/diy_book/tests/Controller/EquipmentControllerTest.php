<?php

namespace App\tests\Controller;

use App\DataFixtures\ProjectFixture;
use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class EquipmentControllerTest extends WebTestCase
{
    use FixturesTrait;

    /**
     * Prefix url
     */
    const BASE_URL="/api/equipment/%s";

    protected function setUp()
    {
        parent::setUp();
        $this->loadFixtures([ProjectFixture::class]);
    }

    /**
     * Get all project tests
     * Expected values : statusCode 200 & Json content
     */
    function testGetAll()
    {
        $client = static::createClient();
        $client->request('GET', sprintf(self::BASE_URL,'all'));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    /**
     * Insert new project
     */
    function testCreate()
    {
        $dataTest = [
            "type" => "wool",
            "quantity" => "100g",
            "color" => "black",
            "projectId" => 1
        ];
        $client = static::createClient();
        $client->request('POST',
            sprintf(self::BASE_URL,'edit'),
            [], [],
            ['CONTENT_TYPE' => 'application/json'], json_encode($dataTest));
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertContains('Created', $client->getResponse()->getContent());
    }

    /**
     * Update project
     */
    function testUpdate()
    {
        $dataTest = [
            "id"=>1,
            "type" => "wool",
            "quantity" => "100g",
            "color" => "black",
            "projectId" => 1
        ];
        $client = static::createClient();
        $client->request('POST',
            sprintf(self::BASE_URL,'edit'),
            [], [],
            ['CONTENT_TYPE' => 'application/json'], json_encode($dataTest));
        $this->assertEquals(202, $client->getResponse()->getStatusCode());
        $this->assertContains('Updated', $client->getResponse()->getContent());
    }

    /**
     * Insert new equipment with bad quantity
     */
    function testCreateBadQuantity()
    {
        $dataTest = [
            "type" => "wool",
            "quantity" => 100,
            "color" => "black",
            "projectId" => 1
        ];
        $client = static::createClient();
        $client->request('POST',
            sprintf(self::BASE_URL,'edit'),
            [], [],
            ['CONTENT_TYPE' => 'application/json'], json_encode($dataTest));
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Fields bad format', $client->getResponse()->getContent());
    }

    /**
     * Insert new equipment with bad type
     */
    function testCreateBadType()
    {
        $dataTest = [
            "type" => 1,
            "quantity" => "100",
            "color" => "black",
            "projectId" => 1
        ];
        $client = static::createClient();
        $client->request('POST',
            sprintf(self::BASE_URL,'edit'),
            [], [],
            ['CONTENT_TYPE' => 'application/json'], json_encode($dataTest));
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString("Fields bad format", $client->getResponse()->getContent());
    }

    /**
     * Insert new equipment without project
     */
    function testCreateWithoutProject()
    {
        $dataTest = [
            "type" => 1,
            "quantity" => "100",
            "color" => "black"
        ];
        $client = static::createClient();
        $client->request('POST',
            sprintf(self::BASE_URL,'edit'),
            [], [],
            ['CONTENT_TYPE' => 'application/json'], json_encode($dataTest));
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString("Json bad format", $client->getResponse()->getContent());
    }

    /**
     * Remove one project
     */
    function testRemoveProject(){
        $client = static::createClient();
        $client->request('GET', sprintf(self::BASE_URL,'remove/1'));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString("Removed successfully", $client->getResponse()->getContent());
    }

    /**
     * Remove one project with bad Id
     */
    function testRemoveProjectWithBadId(){
        $client = static::createClient();
        $client->request('GET', sprintf(self::BASE_URL,'remove/2'));
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString("Error: No object to remove in database", $client->getResponse()->getContent());
    }
}