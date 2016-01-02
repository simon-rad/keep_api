<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity;
use AppBundle\DataFixtures\ORM\Note\Label;
use AppBundle\DataFixtures\BaseFixture;


class Note extends BaseFixture implements DependentFixtureInterface
{
    protected static $loaded;

    public function doLoad(ObjectManager $manager)
    {
        /** @var Label $label */
        $label = $this->getReference(Label::class);

        $note = new Entity\Note();
        $note->setTitle('Test Title');
        $note->setColor('red');
        $note->setType(Entity\Note::TYPE_TEXT);
        $note->setContent('Test Content');
        $note->addLabel($label);

        $manager->persist( $note );

        $this->setReference(static::class, $note);

        $manager->flush();

        return [$note];
    }

    public function getCreatePayload()
    {
        return [
            'title' => 'Test Title',
            'color' => 'red',
            'type' => Entity\Note::TYPE_TEXT,
            'content' => 'Test Content'
        ];
    }

    public function getDependencies()
    {
        return [
            Label::class
        ];
    }
}