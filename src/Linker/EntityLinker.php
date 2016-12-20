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

namespace Suluvir\Linker;


use Fink\config\Configuration;
use Suluvir\Config\SuluvirConfig;
use Suluvir\Linker\Media\ArtistLinker;
use Suluvir\Linker\Media\SongLinker;
use Suluvir\Log\Logger;
use Suluvir\Schema\Media\Artist;
use Suluvir\Schema\Media\Song;

class EntityLinker implements Linker {

    private static $linkers = [
        Song::class => SongLinker::class,
        Artist::class => ArtistLinker::class
    ];

    /**
     * Creates a link for accessing the given object
     *
     * @param object $object the object to create a link for
     * @param string $view an optional view for the object
     * @param Configuration $configuration the configuration to use. Use global config, if {@code null} is given
     * @return string an absolute link to the url describing of this object
     */
    public function link($object, $view = null, Configuration $configuration = null) {
        if ($object === null) {
            throw new \RuntimeException("given object is not allowed to be null");
        }
        if ($configuration === null) {
            $configuration = SuluvirConfig::getConfiguration();
        }
        $class = get_class($object);
        Logger::getLogger()->info("Create link for object of type $class for view $view");

        if (!array_key_exists($class, static::$linkers)) {
            Logger::getLogger()->warning("Trying to create a link for a non configured class. Will return empty string");
            return "";
        }

        $linker = new static::$linkers[$class];
        return $linker->link($object, $view, $configuration);
    }
}
