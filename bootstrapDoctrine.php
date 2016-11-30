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

$config = \Suluvir\Config\Configuration::getConfiguration();
$logger = \Suluvir\Log\Logger::getLogger();
$devMode = $config->get("development");

$paths = ["src/Schema"];

$dbConnection = [
    "driver" => $config->get("database", "driver"),
    "host" => $config->get("database", "host"),
    "user" => $config->get("database", "user"),
    "password" => $config->get("database", "password"),
    "dbname" => $config->get("database", "name")
];

$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $devMode);

$logger->info("Create doctrine entity manager");
$entityManager = \Doctrine\ORM\EntityManager::create($dbConnection, $config);
\Suluvir\Schema\EntityManager::setEntityManager($entityManager);
$logger->info("Created doctrine entity manager");
