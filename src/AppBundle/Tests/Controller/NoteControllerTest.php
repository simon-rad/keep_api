<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Note;
use Doctrine\ORM\PersistentCollection;
use AppBundle\DataFixtures\ORM as Fixture;
use Doctrine\Common\DataFixtures\Loader;

class NoteControllerTest extends ControllerTestAbstract
{
    /**
     * @var Fixture\Note
     */
    private $fixture;

    protected function loadFixtures(Loader $loader)
    {
        $this->fixture = new Fixture\Note();
        $loader->addFixture($this->fixture);
    }

    public function testGetAll()
    {
        $client = static::createClient();
        $client->request('GET', '/note', [], [], $this->getHeaders());
        $this->checkResponse($client);
        $notes = $this->jsonDecodeOrFail($client->getResponse()->getContent());
        $this->collectionTest($notes);
    }

    public function testCreate()
    {
        $client = static::createClient();

        $note = Fixture\Note::getEntity();
        $payload = $this->serializer->normalize($note);
        $payload['id'] = null;
        $customTitle = uniqid();
        $payload['title'] = $customTitle;

        $client->request('POST', '/note', [], [], $this->getHeaders(),
            json_encode($payload, JSON_FORCE_OBJECT)
        );

        $this->checkResponse($client);

        $repository = $this->entityManager->getRepository(Note::class);
        /**
         * @var Note $createdEntity
         */
        $createdEntity = $repository->findOneBy(['title' => $customTitle]);

        $this->assertTrue(!is_null($createdEntity), 'Created entity not found!');

        if($createdEntity)
        {
            /** @var PersistentCollection $labels */
            $labels = $createdEntity->getLabels();
            $this->assertEquals(1, $labels->count());
            $NoteLabel = $labels->offsetGet(0);
            $label = Fixture\Note\Label::getEntity();
            $this->assertEquals($label->getId(), $NoteLabel->getId());
        }
    }

    public function testUpdate()
    {
        $client = static::createClient();

        $note = Fixture\Note::getEntity();
        $payload = $this->serializer->normalize($note);
        $customTitle = uniqid();
        $payload['title'] = $customTitle;

        $client->request('PUT', '/note/'. $note->getId(), [], [], $this->getHeaders(),
            json_encode($payload, JSON_FORCE_OBJECT)
        );

        $this->checkResponse($client);

        $repository = $this->entityManager->getRepository(Note::class);
        /**
         * @var Note $updatedEntity
         */
        $updatedEntity = $repository->findOneBy(['title' => $customTitle]);

        $this->assertTrue(!is_null($updatedEntity), 'Updated entity not found!');
    }

    public function testDelete()
    {
        $client = static::createClient();
        $note = Fixture\Note::getEntity();
        $client->request('DELETE', '/note/'. $note->getId(), [], [], $this->getHeaders());
        $this->checkResponse($client);

        $repository = $this->entityManager->getRepository(Note::class);
        $deletedEntity = $repository->find($note->getId());

        $this->assertTrue(is_null($deletedEntity), 'Entity was not deleted!');

        $this->assertEquals(json_encode([]), $client->getResponse()->getContent());
    }
}
