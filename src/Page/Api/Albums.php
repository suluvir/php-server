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


use Suluvir\Schema\DatabaseManager;
use Suluvir\Schema\Media\Album;
use Yarf\exc\web\HttpBadRequest;
use Yarf\exc\web\HttpNotFound;
use Yarf\page\JsonPage;
use Yarf\response\Response;

class Albums extends JsonPage {

    public function get(Response $response, $albumId) {
        $entityManager = DatabaseManager::getEntityManager();

        if ($albumId === null) {
            $result = $entityManager->getRepository(Album::class)->findAll();
        } else {
            if (is_numeric($albumId)) {
                $artistId = intval($albumId);
                $result = $entityManager->getRepository(Album::class)->find($artistId);
            } else {
                throw new HttpBadRequest("artist id has to be numeric");
            }

            if ($result === null) {
                throw new HttpNotFound();
            }
        }

        $response->result($result);
        return $response;
    }

}
