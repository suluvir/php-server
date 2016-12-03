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

interface Linker {

    /**
     * Creates a link for accessing the given object
     *
     * @param object $object the object to create a link for
     * @param string $view an optional view for the object
     * @param Configuration $configuration the configuration to use. Use global config, if {@code null} is given
     * @return string an absolute link to the url describing of this object
     */
    public function link($object, $view = null, Configuration $configuration = null);

}
