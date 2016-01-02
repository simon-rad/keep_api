<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class NoteControllerTest extends WebTestCase
{
	public function testGetAll()
	{
		$client = static::createClient();
		$client->request('GET', '/note');
		$this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
		$this->assertEquals(json_encode([]), $client->getResponse()->getContent());
	}

	public function testCreate()
	{
		$client = static::createClient();
		$client->request('POST', '/note');
		$this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
		$this->assertEquals(json_encode([]), $client->getResponse()->getContent());
	}

	public function testUpdate()
	{
		$client = static::createClient();
		$client->request('PUT', '/note/1');
		$this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
		$this->assertEquals(json_encode([]), $client->getResponse()->getContent());
	}

	public function testDelete()
	{
		$client = static::createClient();
		$client->request('PUT', '/note/1');
		$this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
		$this->assertEquals(json_encode([]), $client->getResponse()->getContent());
	}
}
