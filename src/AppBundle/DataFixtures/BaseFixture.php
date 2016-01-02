<?php

namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

abstract class BaseFixture extends AbstractFixture
{
    public static function getEntity()
    {
        if(!count(static::$loaded))
        {
            throw new \Exception('No loaded elements found! Keep in mind that loaded element is removed on get!');
        }

        return array_shift(static::$loaded);
    }

    /**
     * @param ObjectManager $manager
     * @return array
     */
    abstract function doLoad(ObjectManager $manager);

    final function load(ObjectManager $manager)
    {
        static::reset();

        $loaded = $this->doLoad($manager);

        if(!is_array($loaded))
        {
            throw new \Exception('doLoad should return array, returned: ' . gettype($loaded));
        }

        array_walk($loaded, [get_called_class(), 'addLoaded']);
    }

    protected static $loaded;

    private static function addLoaded($entity)
    {
        static::$loaded []= $entity;
    }

    private static function reset()
    {
        static::$loaded = [];
    }
}