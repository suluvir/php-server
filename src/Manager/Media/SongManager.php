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

namespace Suluvir\Manager\Media;


use Suluvir\Schema\Media\Song;

class SongManager {

    /**
     * @return Song a new song
     */
    public static function createSong() {
        return new Song();
    }

    /**
     * Calculates the path the audio file for the song is saved
     *
     * @param Song $song the song to get the path for
     */
    public static function getAbsolutePath(Song $song) {

    }

}
