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

namespace Suluvir\Linker\Media;


use Suluvir\Schema\Media\Song;

class SongLinkerTest extends \PHPUnit_Framework_TestCase {

    public function testLinkArtistWithDefaultConfig() {
        $song = $this->createMock(Song::class);
        $song->method("getId")->willReturn(2);

        $linker = new SongLinker();
        $this->assertEquals("http://localhost:8080/api/v1/song/2", $linker->link($song));
        $this->assertEquals("http://localhost:8080/api/v1/song/2/testview", $linker->link($song, "testview"));
    }

}
