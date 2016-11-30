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
     */
    public function upload() {
        $targetDir = $this->getTargetDirectory();
        $targetFile = $targetDir . "test.mp3";
        Logger::getLogger()->info("Uploading {$this->file['name']} to $targetDir");

        move_uploaded_file($this->file["tmp_name"], $targetFile);
    }

    private function getTargetDirectory() {
        $targetDir = Configuration::getConfiguration()->get("upload", "directory");
        if (Configuration::getConfiguration()->get("upload", "relative")) {
            return SULUVIR_ROOT_DIR . $targetDir . "/";
        } else {
            return $targetDir . "/";
        }
    }

}
