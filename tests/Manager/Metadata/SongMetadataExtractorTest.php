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

namespace Suluvir\Manager\Metadata;


use Suluvir\Schema\Media\Song;

class SongMetadataExtractorTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var SongMetadataExtractor
     */
    private $extractor;

    protected function setUp() {
        $fileInfo = [
            "id3v1" => [
                "title" => "test"
            ],
            "filesize" => 1234,
            "playtime_seconds" => 34.23
        ];
        $id3 = $this->createMock(\getID3::class);
        $id3->method("analyze")->willReturn($fileInfo);
        $song = $this->createMock(Song::class);
        $this->extractor = new SongMetadataExtractor($song, $id3);
    }

    public function testGetTitle() {
        $this->assertEquals("test", $this->extractor->getTitle());
    }

    public function testGetFileSize() {
        $this->assertEquals(1234, $this->extractor->getSize());
    }

    public function testGetDuration() {
        $this->assertEquals(34.23, $this->extractor->getDuration());
    }

}
