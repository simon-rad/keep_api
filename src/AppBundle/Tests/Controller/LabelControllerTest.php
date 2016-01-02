<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LabelControllerTest extends WebTestCase
{
	public function testGetAll()
	{
		$client = static::createClient();
		$client->request('GET', '/label');
		$this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
		$this->assertEquals(json_encode([]), $client->getResponse()->getContent());
	}

	public function testCreate()
	{
		$client = static::createClient();
		$client->request('POST', '/label');
		$this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
		$this->assertEquals(json_encode([]), $client->getResponse()->getContent());
	}

	public function testUpdate()
	{
		$client = static::createClient();
		$client->request('PUT', '/label/1');
		$this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
		$this->assertEquals(json_encode([]), $client->getResponse()->getContent());
	}

	public function testDelete()
	{
		$client = static::createClient();
		$client->request('PUT', '/label/1');
		$this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
		$this->assertEquals(json_encode([]), $client->getResponse()->getContent());
	}
}
