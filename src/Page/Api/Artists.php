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
use Suluvir\Schema\Media\Artist;
use Yarf\exc\web\HttpBadRequest;
use Yarf\exc\web\HttpNotFound;
use Yarf\page\JsonPage;
use Yarf\request\Request;
use Yarf\response\Response;

class Artists extends JsonPage {

    public function get(Request $request, Response $response, $artistId) {
        $entityManager = DatabaseManager::getEntityManager();

        if ($artistId === null) {
            $result = $entityManager->getRepository(Artist::class)->findAll();
        } else {
            if (is_numeric($artistId)) {
                $artistId = intval($artistId);
                $result = $entityManager->getRepository(Artist::class)->find($artistId);
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
