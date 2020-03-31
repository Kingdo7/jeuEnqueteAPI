<?php 

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\PropertyAccess\PropertyAccess;

class SerialisationService {
    private $encoders;
    private $normalizers;
    private $serializer;
    private $propertyAccessor;

    public function __construct(){
        // dd($listSuspect);
        $this->encoders = [new XmlEncoder(), new JsonEncoder()];
        $this->normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($this->normalizers, $this->encoders);
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    public function jsonSerialise($resultat){
        return $this->serializer->serialize($resultat, 'json');
    }
}
