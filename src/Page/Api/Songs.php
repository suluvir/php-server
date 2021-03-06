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


use Suluvir\Log\Logger;
use Suluvir\Media\Upload\Uploader;
use Suluvir\Schema\DatabaseManager;
use Suluvir\Schema\Media\Song;
use Yarf\exc\web\HttpBadRequest;
use Yarf\exc\web\HttpInternalServerError;
use Yarf\exc\web\HttpNotFound;
use Yarf\http\Header;
use Yarf\page\JsonPage;
use Yarf\request\Request;
use Yarf\response\Response;

class Songs extends JsonPage {

    public function get(Request $request, Response $response, $songId) {
        $entityManager = DatabaseManager::getEntityManager();

        if ($songId === null) {
            $songs = $entityManager->getRepository(Song::class)->findAll();
        } else {
            if (is_numeric($songId)) {
                $songId = intval($songId);
                $songs = $entityManager->getRepository(Song::class)->find($songId);
            } else {
                throw new HttpBadRequest("song id has to be numeric");
            }
            if ($songs === null) {
                throw new HttpNotFound();
            }
        }

        $response->result($songs);
        return $response;
    }

    public function post(Request $request, Response $response) {
        $uploader = new Uploader($request->get("media"));

        try {
            $song = $uploader->upload();
        } catch (\RuntimeException $e) {
            Logger::getLogger()->error($e->getMessage(), $e->getTrace());
            throw new HttpInternalServerError($e->getMessage());
        }

        $response->result($song);
        return $response;
    }

}
