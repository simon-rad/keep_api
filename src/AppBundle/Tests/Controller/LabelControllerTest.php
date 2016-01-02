<?php

namespace AppBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use AppBundle\DataFixtures\ORM as Fixture;
use Doctrine\Common\DataFixtures\Loader;
use AppBundle\Entity\Note\Label;

class LabelControllerTest extends ControllerTestAbstract
{
    protected function loadFixtures(Loader $loader)
    {
        $loader->addFixture(new Fixture\Note\Label());
    }

    public function testGetAll()
    {
        $client = static::createClient();
        $client->request('GET', '/label', [], [], $this->getHeaders());
        $this->checkResponse($client);
        $labels = $this->jsonDecodeOrFail($client->getResponse()->getContent());
        $this->collectionTest($labels);
    }

    public function testCreate()
    {
        $client = static::createClient();

        $label = Fixture\Note\Label::getEntity();
        $payload = $this->serializer->normalize($label);
        $payload['id'] = null;
        $customName = uniqid();
        $payload['name'] = $customName;

        $client->request('POST', '/label', [], [], $this->getHeaders(),
            json_encode($payload, JSON_FORCE_OBJECT)
        );

        $this->checkResponse($client);

        $repository = $this->entityManager->getRepository(Label::class);
        /**
         * @var Label $createdEntity
         */
        $createdEntity = $repository->findOneBy(['name' => $customName]);

        $this->assertTrue(!is_null($createdEntity), 'Created entity not found!');
    }

    public function testUpdate()
    {
        $client = static::createClient();

        $label = Fixture\Note\Label::getEntity();
        $payload = $this->serializer->normalize($label);
        $customName = uniqid();
        $payload['name'] = $customName;

        $client->request('PUT', '/label/'. $label->getId(), [], [], $this->getHeaders(),
            json_encode($payload, JSON_FORCE_OBJECT)
        );

        $this->checkResponse($client);

        $repository = $this->entityManager->getRepository(Label::class);
        /**
         * @var Label $updatedEntity
         */
        $updatedEntity = $repository->findOneBy(['name' => $customName]);

        $this->assertTrue(!is_null($updatedEntity), 'Updated entity not found!');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $label = Fixture\Note\Label::getEntity();
        $client->request('DELETE', '/label/'. $label->getId(), [], [], $this->getHeaders());
        $this->checkResponse($client);

        $repository = $this->entityManager->getRepository(Label::class);
        $deletedEntity = $repository->find($label->getId());

        $this->assertTrue(is_null($deletedEntity), 'Entity was not deleted!');

        $this->assertEquals(json_encode([]), $client->getResponse()->getContent());
    }
}
