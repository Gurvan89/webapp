<?php

namespace App\tests\Controller;

use App\DataFixtures\ProjectFixture;
use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class ProjectControllerTest extends WebTestCase
{
    use FixturesTrait;

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
        $client->request('GET', '/api/project/all');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    /**
     * Insert new project
     */
    function testCreate()
    {
        $dataTest = [
            "name" => "testName3",
            "description" => "testDescription",
            "estimatedDuration" => 1,
            "type" => "SEWING"
        ];
        $client = static::createClient();
        $client->request('POST',
            '/api/project/edit',
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
            "name" => "testName3",
            "description" => "testDescription",
            "estimatedDuration" => 1,
            "type" => "SEWING"
        ];
        $client = static::createClient();
        $client->request('POST',
            '/api/project/edit',
            [], [],
            ['CONTENT_TYPE' => 'application/json'], json_encode($dataTest));
        $this->assertEquals(202, $client->getResponse()->getStatusCode());
        $this->assertContains('Updated', $client->getResponse()->getContent());
    }

    /**
     * Insert new project with bad estimated duration
     */
    function testCreateBadEstimatedDuration()
    {
        $dataTest = [
            "name" => "testName",
            "description" => "testDescription",
            "estimatedDuration" => "testEstimatedDuration",
            "type" => "SEWING"
        ];
        $client = static::createClient();
        $client->request('POST',
            '/api/project/edit',
            [], [],
            ['CONTENT_TYPE' => 'application/json'], json_encode($dataTest));
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Json bad format. Estimated duration has to be an integer', $client->getResponse()->getContent());
    }

    /**
     * Insert new project with bad type
     */
    function testCreateBadType()
    {
        $dataTest = [
            "name" => "testName",
            "description" => "testDescription",
            "estimatedDuration" => 100,
            "type" => "badType"
        ];
        $client = static::createClient();
        $client->request('POST',
            '/api/project/edit',
            [], [],
            ['CONTENT_TYPE' => 'application/json'], json_encode($dataTest));
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString(sprintf("Json bad format. Type authorized: %s", join(",", Project::AUTHORIZED_TYPES)), $client->getResponse()->getContent());
    }

    /**
     * Insert new project with bad type
     */
    function testCreateInsertExistingName()
    {
        $dataTest = [
            "name" => "testName",
            "description" => "testDescription",
            "estimatedDuration" => 100,
            "type" => "SEWING"
        ];
        $client = static::createClient();
        $client->request('POST',
            '/api/project/edit',
            [], [],
            ['CONTENT_TYPE' => 'application/json'], json_encode($dataTest));
        $client->request('POST',
            '/api/project/edit',
            [], [],
            ['CONTENT_TYPE' => 'application/json'], json_encode($dataTest));
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString("Name already exists in database", $client->getResponse()->getContent());
    }

    /**
     * Remove one project
     */
    function testRemoveProject(){
        $client = static::createClient();
        $client->request('GET', '/api/project/remove/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString("Removed successfully", $client->getResponse()->getContent());
    }

    /**
     * Remove one project with bad Id
     */
    function testRemoveProjectWithBadId(){
        $client = static::createClient();
        $client->request('GET', '/api/project/remove/2');
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString("Error: No object to remove in database", $client->getResponse()->getContent());
    }
}