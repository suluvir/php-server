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
            "song" => [
                "" => \Suluvir\Page\Api\Song::class,
                "{songId}" => \Suluvir\Page\Api\Song::class
            ]
        ]
    ],

    "upload" => \Suluvir\Page\Upload::class
];

$router = new \Yarf\Router();
$router->route($pageMap);
