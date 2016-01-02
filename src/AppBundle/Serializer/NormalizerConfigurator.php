<?php

namespace AppBundle\Serializer;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class NormalizerConfigurator
{
    public function configure(ObjectNormalizer $normalizer)
    {
        $normalizer->setCircularReferenceHandler(function($object){
            return $object->getId();
        });
    }
}