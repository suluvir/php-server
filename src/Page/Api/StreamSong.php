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

namespace Suluvir\Page\Api;


use Suluvir\Manager\Media\SongManager;
use Suluvir\Schema\DatabaseManager;
use Suluvir\Schema\Media\Song;
use Yarf\exc\web\HttpBadRequest;
use Yarf\exc\web\HttpNotFound;
use Yarf\http\Header;
use Yarf\page\TextPage;
use Yarf\response\Response;

class StreamSong extends TextPage {

    public function get(Response $response, $songId) {
        if ($songId === null || !is_numeric($songId)) {
            throw new HttpBadRequest("song id has to be numeric");
        }
        $em = DatabaseManager::getEntityManager();
        $song = $em->getRepository(Song::class)->find(intval($songId));
        if ($song === null) {
            throw new HttpNotFound();
        }

        $path = SongManager::getAbsolutePath($song);
        $contentType = SongManager::getContentType($song);
        $contentDisposition = "inline;filename=\"{$song->getTitle()}.{$song->getExtension()}\"";

        $response->addHeader(Header::CONTENT_TYPE, $contentType);
        $response->addHeader(Header::CONTENT_DISPOSITION, $contentDisposition);
        $response->addHeader(Header::CONTENT_LENGTH, $song->getSize());

        $response->result(file_get_contents($path));
        return $response;
    }

}
