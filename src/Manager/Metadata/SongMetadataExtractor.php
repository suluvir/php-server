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
use Suluvir\Manager\Media\AlbumManager;
use Suluvir\Manager\Media\ArtistManager;
use Suluvir\Manager\Media\SongManager;
use Suluvir\Schema\Media\Album;
use Suluvir\Schema\Media\Artist;
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

    /**
     * @var Artist[] the cached artists
     */
    private $artists;

    public function __construct(Song $song, \getID3 $getID3 = null) {
        $this->getId3 = $getID3 === null ? new \getID3() : $getID3;
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
        $this->analyze();
        return $this->fileInfo["filesize"];
    }

    /**
     * @return double the songs duration
     */
    public function getDuration() {
        $this->analyze();
        return $this->fileInfo["playtime_seconds"];
    }

    /**
     * @return Artist[] all artists of this song
     */
    public function getArtists() {
        if ($this->artists !== null) {
            return $this->artists;
        }
        $this->analyze();
        $artistNames = $this->extractArtistNames($this->fileInfo["tags"]["id3v1"]["artist"]);
        $artists = [];

        foreach ($artistNames as $artistName) {
            $artist = ArtistManager::getArtistByName($artistName);
            if ($artist !== null) {
                $artists[] = $artist;
            }
        }

        $this->artists = $artists;

        return $artists;
    }

    /**
     * Returns the first artist from the list of artists, if there is
     * at least one artist. Will return {@code null}, if there are no artists for this song.
     *
     * @return null|Artist the main artist of this song
     */
    public function getMainArtist() {
        $artists = $this->getArtists();
        if (count($artists) >= 1) {
            return $artists[0];
        }
        return null;
    }

    /**
     * Extracts the songs album and fetches it from database. Will create a new album,
     * if no album with the extracted name exists for the extracted artists. The main
     * artist will be used.
     *
     * @return Album|null the album of this song.
     */
    public function getAlbum() {
        $this->analyze();
        $artist = $this->getMainArtist();

        $albumName = $this->fileInfo["tags"]["id3v1"]["album"];
        if ($albumName === "" || $albumName === null) {
            return null;
        }
        return AlbumManager::getAlbumByNameAndArtist($albumName, $artist);
    }

    /**
     * @param array $artistNames
     * @return array the extracted artist names
     */
    private function extractArtistNames(array $artistNames) {
        $result = [];

        foreach ($artistNames as $artistName) {
            $explodedArtistNames = preg_split("/,|feat\.?|ft\./", $artistName);
            foreach ($explodedArtistNames as $explodedArtistName) {
                $result[] = trim($explodedArtistName);
            }
        }

        return $result;
    }

}
