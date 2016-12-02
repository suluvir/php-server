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

/**
 * Created by PhpStorm.
 * User: jannis
 * Date: 02.12.16
 * Time: 12:17
 */

namespace Suluvir\Manager\Media;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;
use Suluvir\Schema\Media\Artist;

class ArtistManagerTest extends TestCase {

    public function testCreateArtist() {
        $artist = ArtistManager::createArtist("test");
        $this->assertInstanceOf(Artist::class, $artist);
        $this->assertEquals("test", $artist->getName());
    }

    public function testGetArtistByNameNull() {
        $this->assertNull(ArtistManager::getArtistByName(null));
    }

    public function testGetArtistByNameEmptyString() {
        $this->assertNull(ArtistManager::getArtistByName(""));
    }

    public function testGetArtistFromDb() {
        $em = $this->createMock(EntityManager::class);
        $repo = $this->createMock(EntityRepository::class);
        $artist = ArtistManager::createArtist("test");
        $repo->method("findOneBy")->willReturn($artist);
        $em->method("getRepository")->willReturn($repo);

        $result = ArtistManager::getArtistByName("test", $em);
        $this->assertEquals($artist, $result);
        $this->assertEquals($artist->getName(), $result->getName());
    }

    public function testGetArtistCreateNew() {
        $em = $this->createMock(EntityManager::class);
        $repo = $this->createMock(EntityRepository::class);
        $repo->method("findOneBy")->willReturn(null);
        $em->method("getRepository")->willReturn($repo);

        $result = ArtistManager::getArtistByName("test");
        $this->assertInstanceOf(Artist::class, $result);
        $this->assertEquals("test", $result->getName());
    }

}
