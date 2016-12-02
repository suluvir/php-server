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

namespace Suluvir\Config;


use Fink\config\Configuration;
use Suluvir\Log\Logger;

class SuluvirConfig {

    private static $configuration;

    /**
     * @return \Fink\config\Configuration the loaded configuration
     * @throws \Exception if the configuration is not loaded yet
     */
    public static function getConfiguration() {
        if (self::$configuration === null) {
            throw new \Exception("configuration is not yet loaded");
        }
        return self::$configuration;
    }

    /**
     * @param $configurationFile string the file name of the configuration file to use
     */
    public static function loadConfiguration($configurationFile) {
        self::$configuration = new Configuration($configurationFile);

        Logger::getLogger()->debug("loaded configuration", self::$configuration->get());
    }

}
