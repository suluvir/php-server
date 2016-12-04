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

namespace Suluvir\Media\Upload;


use Suluvir\Config\SuluvirConfig;
use Suluvir\Log\Logger;
use Suluvir\Manager\Media\SongManager;
use Suluvir\Schema\DatabaseManager;
use Suluvir\Schema\Media\Song;

class Uploader {

    /**
     * @var array
     */
    private $file;

    /**
     * Uploader constructor.
     * @param string $file the name of the form field the file was uploaded
     */
    public function __construct($file) {
        $this->file = $file;
    }

    /**
     * Uploads the file given in constructor to a directory specified in the config
     *
     * @return Song the uploaded song
     * @throws \RuntimeException if the song cannot be uploaded
     */
    public function upload() {
        $logger = Logger::getLogger();
        if ($this->file["error"] == UPLOAD_ERR_FORM_SIZE || $this->file["error"] == UPLOAD_ERR_INI_SIZE) {
            $logger->critical("File size of uploaded song exceeds limit configured", $this->file);
        }
        $song = SongManager::createSong($this->file["name"]);
        $targetFile = SongManager::getAbsolutePath($song);
        Logger::getLogger()->info("Uploading {$this->file['name']} to $targetFile", $this->file);

        if (move_uploaded_file($this->file["tmp_name"], $targetFile)) {
            $song = SongManager::popularizeMetadata($song);
            foreach ($song->getArtists() as $artist) {
                DatabaseManager::getEntityManager()->persist($artist);
            }
            if ($song->getAlbum() !== null) {
                DatabaseManager::getEntityManager()->persist($song->getAlbum());
            }
            DatabaseManager::getEntityManager()->persist($song);
        } else {
            throw new \RuntimeException("can't upload song");
        }

        return $song;
    }

}
