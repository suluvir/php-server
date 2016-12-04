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

namespace Suluvir\Manager\Media;


use Doctrine\ORM\EntityManager;
use Suluvir\Schema\DatabaseManager;
use Suluvir\Schema\Media\Album;
use Suluvir\Schema\Media\Artist;

class AlbumManager {

    /**
     * @param $name
     * @param Artist|null $artist
     * @return Album
     */
    public static function createAlbum($name, Artist $artist = null) {
        return new Album($name, $artist);
    }

    /**
     * @param string $name the name of the album
     * @param Artist|null $artist the artist of this album
     * @param EntityManager|null $entityManager the entity manager to use
     * @return Album the album
     */
    public static function getAlbumByNameAndArtist($name, Artist $artist = null, EntityManager $entityManager = null) {
        $entityManager = $entityManager === null ? DatabaseManager::getEntityManager() : $entityManager;

        $albums = $entityManager->getRepository(Album::class)->findBy(["name" => $name]);
        foreach ($albums as $album) {
            if ($album->getArtist() == $artist) {
                return $album;
            }
        }
        return self::createAlbum($name, $artist);
    }

}
