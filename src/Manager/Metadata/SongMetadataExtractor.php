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
use Suluvir\Log\Logger;
use Suluvir\Manager\Media\SongManager;
use Suluvir\Schema\Media\Song;

/**
 * Class MetadataExtractor
 *
 * This class extracts all possible metadata from the given song
 *
 * @package Suluvir\Manager\Metadata
 */
class SongMetadataExtractor {

    /**
     * @var \getID3 the extractor
     */
    private $getId3;

    /**
     * @var Song the song to extract metadata for
     */
    private $song;

    /**
     * @var array the file info
     */
    private $fileInfo;

    /**
     * @var bool flag to see, if the fileinfo was already analyzed
     */
    private $analyzed;

    public function __construct(Song $song) {
        $this->getId3 = new \getID3();
        $this->song = $song;
    }

    private function analyze() {
        if ($this->analyzed) {
            return;
        }
        $fileName = SongManager::getAbsolutePath($this->song);
        $this->fileInfo = $this->getId3->analyze($fileName);
        Logger::getLogger()->info("Analyzed $fileName, information got: " . var_export($this->fileInfo, true));
        $this->analyzed = true;
    }

    /**
     * @return string the title
     */
    public function getTitle() {
        $this->analyze();
        return $this->fileInfo["id3v1"]["title"];
    }

    /**
     * @return int the size in bytes
     */
    public function getSize() {
        return filesize(SongManager::getAbsolutePath($this->song));
    }

}