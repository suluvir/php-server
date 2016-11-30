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

namespace Suluvir\Schema;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\MappedSuperclass;


/**
 * Class DatabaseObject
 *
 * @MappedSuperclass
 */
abstract class DatabaseObject implements \JsonSerializable {

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     *
     * @var int the primary key
     */
    protected $id;

    public function jsonSerialize() {
        $result = [];
        $reflectionObject = new \ReflectionObject($this);

        foreach ($reflectionObject->getProperties() as $property) {
            $accessible = $property->isPrivate() || $property->isProtected();
            $property->setAccessible(true);
            $result[$property->getName()] = $this->serializeDatetime($property->getValue($this));
            $property->setAccessible($accessible);
        }
        return $result;
    }

    private function serializeDatetime($value) {
        if ($value instanceof \DateTime) {
            return $value->format(DATE_ISO8601);
        }
        return $value;
    }

}
