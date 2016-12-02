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


use Fink\config\Configuration;
use PHPUnit\Framework\TestCase;
use Suluvir\Schema\Media\Song;

class SongManagerTest extends TestCase {

    public function testCreateSong() {
        $song = SongManager::createSong("test.mp3");

        $this->assertInstanceOf(Song::class, $song);
        $this->assertEquals("mp3", $song->getExtension());
    }

    public function testGetAbsolutePathWithDefaultConfiguration() {
        $song = $this->createMock(Song::class);
        $song->method("getFileName")->willReturn("test");

        $path = SongManager::getAbsolutePath($song);
        $this->assertEquals(SULUVIR_ROOT_DIR . "uploads/test", $path);
    }

    public function testGetAbsolutePathWithAbsolutePathConfiguration() {
        $song = $this->createMock(Song::class);
        $song->method("getFileName")->willReturn("test");

        $map = [
            ["upload", "directory", "/home"],
            ["upload", "relative", false]
        ];
        $config = $this->createMock(Configuration::class);
        $config->method("get")->will($this->returnValueMap($map));

        $path = SongManager::getAbsolutePath($song, $config);
        $this->assertEquals("/home/test", $path);
    }

}
