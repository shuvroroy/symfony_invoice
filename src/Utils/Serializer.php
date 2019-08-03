<?php

namespace App\Utils;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as BaseSerializer;

class Serializer
{
    public function serialize($data, $format = 'json',  $context = [])
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new BaseSerializer($normalizers, $encoders);

        return $serializer->serialize($data, $format, $context);
    }
}