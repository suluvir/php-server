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


use Suluvir\Config\Configuration;
use Suluvir\Log\Logger;
use Suluvir\Manager\Media\SongManager;
use Suluvir\Schema\EntityManager;
use Suluvir\Schema\Media\Song;

class Uploader {

    /**
     * @var string
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
        $song = SongManager::createSong($this->file["name"]);
        $targetFile = SongManager::getAbsolutePath($song);
        Logger::getLogger()->info("Uploading {$this->file['name']} to $targetFile");

        if (move_uploaded_file($this->file["tmp_name"], $targetFile)) {
            $song = SongManager::popularizeMetadata($song);
            EntityManager::getEntityManager()->persist($song);
        } else {
            throw new \RuntimeException("can't upload song");
        }

        return $song;
    }

}
