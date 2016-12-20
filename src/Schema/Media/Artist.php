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
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;
use Suluvir\Schema\DatabaseObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Artist
 *
 * This class represents the artists who make the songs.
 *
 * @Entity
 * @Table(name="media_artist")
 *
 * @package Suluvir\Schema\Media
 */
class Artist extends DatabaseObject {

    protected static $skipDeeplySerializeProperties = ["songs"];

    /**
     * @ManyToMany(targetEntity="Suluvir\Schema\Media\Song", mappedBy="artists")
     *
     * @Groups({"api"})
     *
     * @var Song[]
     */
    private $songs;

    /**
     * @Column(type="string", length=4096)
     *
     * @Groups({"api"})
     *
     * @var string the artists name
     */
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    /**
     * @return string the artists name
     */
    public function getName() {
        return $this->name;
    }

}
