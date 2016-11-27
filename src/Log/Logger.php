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

namespace Suluvir\Log;


use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;
use Suluvir\Config\Configuration;

class Logger {

    /**
     * @var LoggerInterface[] an associative array of all active loggers
     */
    private static $loggers = [];

    /**
     * Returns a logger fpr a given name. Creates one, if there is not already
     * a logger for the given name
     *
     * @param string $name the name for the logger
     * @return LoggerInterface the logger for the given name
     */
    public static function getLogger($name = SULUVIR_DEFAULT_LOGGER) {
        if (!array_key_exists($name, self::$loggers)) {
            return self::createLogger($name);
        }
        return self::$loggers[$name];
    }

    /**
     * Mainly for testing purposes. Clears all active loggers.
     */
    public static function clearLoggers() {
        self::$loggers = [];
    }

    /**
     * @param $name string the name for the new logger
     * @return LoggerInterface the new logger for the given name
     * @throws \Exception if there is already a logger existent for the given name
     */
    private static function createLogger($name) {
        if (array_key_exists($name, self::$loggers)) {
            throw new \Exception("Logger with name $name already exists");
        }

        $logger = new \Monolog\Logger($name);
        $loggingDirectory = Configuration::getConfiguration()->get("log", "directory");
        $fileType = Configuration::getConfiguration()->get("log", "file_type");

        $fileName = SULUVIR_ROOT_DIR . $loggingDirectory . strtolower($name) . $fileType;

        $logger->pushHandler(new StreamHandler($fileName, \Monolog\Logger::DEBUG));

        self::$loggers[$name] = $logger;
        return $logger;
    }

}
