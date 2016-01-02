<?php

namespace AppBundle\DBAL\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class NoteType extends Type
{
    const NAME = 'NoteType';
    const TYPE_TEXT = 'text';
    const TYPE_LIST = 'list';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return sprintf("ENUM('%s', '%s') COMMENT '(DC2Type:%s)'",
                self::TYPE_TEXT, self::TYPE_LIST, self::NAME);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, array(self::TYPE_TEXT, self::TYPE_LIST))) {
            throw new \InvalidArgumentException("Invalid type");
        }
        return $value;
    }

    public function getName()
    {
        return self::NAME;
    }

    public static function getTypes()
    {
        return [
            self::TYPE_TEXT,
            self::TYPE_LIST
        ];
    }
}