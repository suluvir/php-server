<?php
// Copyright 2016 Jannis Fink
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

namespace Suluvir\Serialize;


use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Suluvir\Linker\EntityLinker;
use Suluvir\Log\Logger;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Yarf\exc\SerializeException;
use Yarf\serialize\Serializer;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Doctrine\Common\Annotations\AnnotationReader;

class JsonSerializer implements Serializer {

    private $serializer;

    function __construct() {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new PropertyNormalizer($classMetadataFactory);

        $normalizer->setCallbacks($this->getCallbacks());
        $normalizer->setCircularReferenceHandler($this->getReferenceHandler());

        $encoders = [new JsonEncoder()];

        $this->serializer = new \Symfony\Component\Serializer\Serializer([$normalizer], $encoders);
    }

    /**
     * @param mixed $object the object to serialize
     * @return array the object serialized
     * @throws SerializeException when anything goes wrong
     */
    public function serialize($object) {
        $data = $this->serializer->normalize($object, null, ["groups" => ["api"]]);
        return $this->serializer->serialize($data, "json");
    }

    private function getCallbacks() {
        return [
//            "artists" => $this->getReferenceHandler(),
            "creation" => function ($datetime) {
                return $datetime instanceof \DateTime ? $datetime->format(DATE_ISO8601) : '';
            }
        ];
    }

    private function getReferenceHandler() {
        return function ($object) {
            $linker = new EntityLinker();
            return $linker->link($object);
        };
    }
}
