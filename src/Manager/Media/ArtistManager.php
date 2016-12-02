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


use Suluvir\Schema\EntityManager;
use Suluvir\Schema\Media\Artist;

class ArtistManager {

    /**
     * Creates a new artist
     *
     * @param string $name the name of the artist
     * @return Artist a new artist
     */
    public static function createArtist($name) {
        return new Artist($name);
    }

    /**
     * Gets an existing artist from database or creates a new one, if there is no one present in the
     * database, yet.
     *
     * @param string $name the name of the artist
     * @return Artist an existing artist in the database or a new one, if it does not exist right now
     */
    public static function getArtistByName($name) {
        $em = EntityManager::getEntityManager();
        $dbArtist = $em->getRepository(Artist::class)->findOneBy(["name" => $name]);
        return $dbArtist !== null ? $dbArtist : static::createArtist($name);
    }

}
