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
    private $fileName;

    /**
     * @Column(type="string", length=10)
     *
     * @var string the file type extension
     */
    private $extension;

    /**
     * @Column(type="integer")
     *
     * @var int the file size in byte
     */
    private $size;

    /**
     * @Column(type="string", length=1024, nullable=true)
     *
     * @var string the songs title
     */
    private $title;

    /**
     * @Column(type="datetime")
     *
     * @var \DateTime time of creation
     */
    private $creation;

    public function __construct($fileName) {
        $this->fileName = Uuid::uuid4()->toString();
        $this->extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $this->creation = new \DateTime();
    }

    /**
     * @return string
     */
    public function getFileName() {
        return $this->fileName;
    }

    /**
     * @return string the file extension
     */
    public function getExtension() {
        return $this->extension;
    }

    /**
     * @return int the file size
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * @return string the title
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title the new title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @param int $size the new size
     */
    public function setSize($size) {
        $this->size = $size;
    }

}
