<?php

namespace AppBundle\DataFixtures\ORM\Note;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity;
use AppBundle\DataFixtures\ORM\Note;
use AppBundle\DataFixtures\BaseFixture;

class Label extends BaseFixture
{
    protected static $loaded;

    public function doLoad(ObjectManager $manager)
    {
        $note = new Entity\Note\Label();
        $note->setName('Test Label');

        $manager->persist( $note );
        $this->setReference(static::class, $note);
        $manager->flush();

        return [$note];
    }
}