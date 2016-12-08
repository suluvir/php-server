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
use Doctrine\ORM\PersistentCollection;
use Suluvir\Config\SuluvirConfig;
use Suluvir\Linker\EntityLinker;


/**
 * Class DatabaseObject
 *
 * @MappedSuperclass
 */
abstract class DatabaseObject implements \JsonSerializable {

    /**
     * An array containing the properties to skip serializing deeply.
     *
     * @var array properties to skip serializing
     */
    protected static $skipDeeplySerializeProperties = [];

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     *
     * @var int the primary key
     */
    protected $id;

    /**
     * @return int the primary key of this object
     */
    public function getId() {
        return $this->id;
    }

    public function jsonSerialize() {
        $result = [];

        $reflectionObject = new \ReflectionObject($this);
        $linker = new EntityLinker();

        foreach ($reflectionObject->getProperties() as $property) {
            if ($property->isStatic()) {
                continue;
            }
            $accessible = $property->isPrivate() || $property->isProtected();
            $property->setAccessible(true);
            $value =  $property->getValue($this);
            if (!$this->shouldSerializeValue($value)) {
                // don't serialize complex types, link to the views
                $value = $linker->link($this, $property->getName());
                $result["link:" . $property->getName()] = $value;
            } else {
                $value =  $property->getValue($this);
                $value = $this->serializeValue($value);
                $result[$property->getName()] = $value;
            }
            $property->setAccessible($accessible);
        }

        $result = $this->addJsonLdKeys($result);
        return $result;
    }

    private function shouldSerializeValue($value) {
        return is_string($value) || is_numeric($value)
            || is_bool($value) || is_array($value) || $value instanceof \DateTime;
    }

    private function serializeValue($value) {
        if ($value instanceof \DateTime) {
            return $value->format(DATE_ISO8601);
        }
        return $value;
    }

    private function addJsonLdKeys(array $serialized) {
        $linker = new EntityLinker();
        $serialized["@id"] = $linker->link($this);
        return $serialized;
    }

}
