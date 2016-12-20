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

require_once __DIR__ . "/vendor/autoload.php";

// see this post:
// http://stackoverflow.com/questions/14629137/jmsserializer-stand-alone-annotation-does-not-exist-or-cannot-be-auto-loaded
\Doctrine\Common\Annotations\AnnotationRegistry::registerFile(
    __DIR__.'/vendor/symfony/serializer/Annotation/Groups.php'
);

mb_internal_encoding(SULUVIR_ENCODING);

define("SULUVIR_ROOT_DIR", __DIR__ . "/");

$configFile = __DIR__ . SULUVIR_CONFIG_FILE;
if (!file_exists($configFile)) {
    $configFile = __DIR__ . SULUVIR_FALLBACK_CONFIG_FILE;
}

\Suluvir\Config\SuluvirConfig::loadConfiguration($configFile);

require_once SULUVIR_ROOT_DIR . "bootstrapDoctrine.php";
