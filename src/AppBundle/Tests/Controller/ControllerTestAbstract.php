<?php

namespace AppBundle\Tests\Controller;

use AppKernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;


abstract class ControllerTestAbstract extends WebTestCase
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var \Symfony\Component\Serializer\Serializer
     */
    protected $serializer;

    private $pathsToFixtures = [];

    protected function loadFixtures(Loader $loader)
    {
        $this->loadAllFixtures($loader);
    }

    protected function jsonDecodeOrFail($raw)
    {
        $data = json_decode($raw);

        if(json_last_error() !== JSON_ERROR_NONE)
        {
            $this->fail(json_last_error_msg());
            return null;
        }

        return $data;
    }

    protected function collectionTest(array $collection)
    {
        $this->assertInternalType( 'array', $collection );
        $this->assertTrue((bool)count($collection), 'Collection is empty!');
        $this->assertObjectHasAttribute( 'id', current($collection), 'Element do not have identity!' );
    }

    protected function checkResponse(Client $client)
    {
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode(),
            $client->getResponse()->getContent()
        );
    }

    protected function getHeaders()
    {
        return ['CONTENT_TYPE' => 'application/json',
            'HTTP_Accept' => 'console/output'];
    }

    private function loadAllFixtures(Loader $loader)
    {
        foreach($this->pathsToFixtures as $path)
        {
            $loader->loadFromDirectory($path);
        }
    }

    public function setUp()
    {
        $kernelNameClass = $this->getKernelClass();

        /* @var $kernel AppKernel */
        $kernel = new $kernelNameClass('test', true);
        $kernel->boot();

        $fixturesPaths = [
            '%s/../src/AppBundle/DataFixtures/ORM'
        ];

        foreach($fixturesPaths as $fixturePath)
        {
            $this->pathsToFixtures []= sprintf($fixturePath, $kernel->getRootDir());
        }

        $this->entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->container = $kernel->getContainer();
        $this->serializer = $this->container->get('serializer');

        $loader = new Loader;
        $this->loadFixtures($loader);

        $purger = new ORMPurger;
        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute($loader->getFixtures());
    }
}