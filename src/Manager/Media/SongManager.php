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


use Suluvir\Config\SuluvirConfig;
use Suluvir\Manager\Metadata\SongMetadataExtractor;
use Suluvir\Schema\Media\Song;

class SongManager {

    /**
     * @param string $fileName the filename
     * @return Song a new song
     */
    public static function createSong($fileName) {
        return new Song($fileName);
    }

    /**
     * Calculates the path the audio file for the song is saved
     *
     * @param Song $song the song to get the path for
     * @return string the absolute file name for the given songs audio file
     */
    public static function getAbsolutePath(Song $song) {
        $config = SuluvirConfig::getConfiguration();
        $directory = $config->get("upload", "directory");
        if ($config->get("upload", "relative")) {
            $directory = SULUVIR_ROOT_DIR . $directory;
        }
        $directory = $directory . "/";
        return $directory . $song->getFileName();
    }

    /**
     * @param Song $song the song to popularize the metadata for
     * @return Song the song with popularized metadata
     */
    public static function popularizeMetadata(Song $song) {
        $metadataExtractor = new SongMetadataExtractor($song);

        $song->setTitle($metadataExtractor->getTitle());
        $song->setSize($metadataExtractor->getSize());
        $song->setDuration($metadataExtractor->getDuration());
        $song->setArtists($metadataExtractor->getArtists());

        return $song;
    }

}
