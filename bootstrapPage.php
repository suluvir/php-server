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

$pageMap = [
    "" => \Suluvir\Page\Index::class,

    "api" => [
        "v1" => [
            "album" => [
                "" => \Suluvir\Page\Api\Albums::class,
                "{albumId}" => \Suluvir\Page\Api\Albums::class
            ],
            "artist" => [
                "" => \Suluvir\Page\Api\Artists::class,
                "{artistId}" => \Suluvir\Page\Api\Artists::class
            ],
            "song" => [
                "" => \Suluvir\Page\Api\Songs::class,
                "{songId}" => [
                    "" => \Suluvir\Page\Api\Songs::class,
                    "stream" => \Suluvir\Page\Api\StreamSong::class,
                    "{view}" => \Suluvir\Page\Api\Relationships\SongRelationships::class
                ]
            ]
        ]
    ],

    "upload" => \Suluvir\Page\Upload::class
];

$router = new \Yarf\Router();
$router->setJsonSerializer(new \Suluvir\Serialize\JsonSerializer());
$router->route($pageMap);
