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
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Suluvir\Schema\DatabaseObject;

/**
 * Class Album
 *
 * @Entity
 * @Table(name="media_album")
 *
 * @package Suluvir\Schema\Media
 */
class Album extends DatabaseObject {

    /**
     * @ManyToOne(targetEntity="Suluvir\Schema\Media\Artist", fetch="LAZY")
     *
     * @var Artist the artist of the album
     */
    private $artist;

    /**
     * @OneToMany(targetEntity="Suluvir\Schema\Media\Song", fetch="LAZY", mappedBy="album")
     *
     * @var Song[] the album songs
     */
    private $songs;

    /**
     * @Column(type="string", length=4096)
     *
     * @var string the album name
     */
    private $name;

    public function __construct($name, Artist $artist = null) {
        $this->songs = [];
        $this->name = $name;
        $this->artist = $artist;
    }

    /**
     * @return Artist
     */
    public function getArtist() {
        return $this->artist;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return Song[]
     */
    public function getSongs() {
        return $this->songs;
    }

    public function addSong(Song $song) {
        $this->songs[] = $song;
    }

}
