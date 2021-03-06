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
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\Uuid;
use Suluvir\Linker\EntityLinker;
use Suluvir\Schema\DatabaseObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Song
 *
 * @Entity
 * @Table(name="media_song")
 *
 * @package Suluvir\Schema\Media
 */
class Song extends DatabaseObject {

    protected static $skipDeeplySerializeProperties = ["artists"];

    /**
     * @ManyToMany(targetEntity="Suluvir\Schema\Media\Artist", inversedBy="songs")
     * @JoinTable(name="media_song_artist")
     *
     * @Groups({"api"})
     *
     * @var Artist[] the songs artists
     */
    private $artists;

    /**
     * @ManyToOne(targetEntity="Suluvir\Schema\Media\Album", fetch="LAZY", inversedBy="songs")
     * @JoinColumn(name="album_id", referencedColumnName="id")
     *
     * @Groups({"api"})
     *
     * @var Album the songs album
     */
    private $album;

    /**
     * @Column(type="string", length=50)
     *
     * @Groups({"api"})
     *
     * @var string the name of the file (without directory prefix)
     */
    private $fileName;

    /**
     * @Column(type="string", length=10)
     *
     * @Groups({"api"})
     *
     * @var string the file type extension
     */
    private $extension;

    /**
     * @Column(type="integer")
     *
     * @Groups({"api"})
     *
     * @var int the file size in byte
     */
    private $size;

    /**
     * @Column(type="string", length=1024, nullable=true)
     *
     * @Groups({"api"})
     *
     * @var string the songs title
     */
    private $title;

    /**
     * @Column(type="float", nullable=true)
     *
     * @Groups({"api"})
     *
     * @var double duration of the song, in seconds
     */
    private $duration;

    /**
     * @Column(type="datetime")
     *
     * @Groups({"api"})
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
     * @return double the songs duration, in seconds
     */
    public function getDuration() {
        return $this->duration;
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

    /**
     * @param double $duration
     */
    public function setDuration($duration) {
        $this->duration = $duration;
    }

    /**
     * @param Artist[] $artists the new artists
     */
    public function setArtists($artists) {
        $this->artists = $artists;
    }

    /**
     * @return Artist[]
     */
    public function getArtists() {
        return $this->artists;
    }

    /**
     * @param Album $album
     */
    public function setAlbum($album) {
        $this->album = $album;
    }

    /**
     * @return Album
     */
    public function getAlbum() {
        return $this->album;
    }

    public function jsonSerialize() {
        $result = parent::jsonSerialize();
        $linker = new EntityLinker();
        $result["link:stream"] = $linker->link($this, "stream");
        return $result;
    }

}
