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

namespace Suluvir\Schema\Media;


use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\Uuid;
use Suluvir\Schema\DatabaseObject;

/**
 * Class Song
 *
 * @Entity
 * @Table(name="media_song")
 *
 * @package Suluvir\Schema\Media
 */
class Song extends DatabaseObject {

    /**
     * @Column(type="string", length=50)
     *
     * @var string the name of the file (without directory prefix)
     */
    private $name;

    /**
     * @Column(type="datetime")
     *
     * @var \DateTime time of creation
     */
    private $creation;

    public function __construct() {
        $this->name = Uuid::uuid4()->toString() . ".mp3";
        $this->creation = new \DateTime();
    }

    /**
     * @return string name of the file
     */
    public function getName() {
        return $this->name;
    }

}
