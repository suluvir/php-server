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

namespace Suluvir\Page;


use Suluvir\Log\Logger;
use Suluvir\Media\Upload\Uploader;
use Yarf\exc\web\HttpInternalServerError;
use Yarf\page\HtmlPage;
use Yarf\request\Request;
use Yarf\response\Response;

/**
 * Class Upload
 *
 * This is a (temporary) page for testing the upload of mp3 files
 *
 * @package Suluvir\Page
 */
class Upload extends HtmlPage {

    public function get(Response $response) {
        $fileContents = file_get_contents(SULUVIR_ROOT_DIR . "templates/html/upload.html");
        $response->result($fileContents);
        return $response;
    }

    public function post(Request $request, Response $response) {
        $uploader = new Uploader($request->get("media"));

        try {
            $uploader->upload();
        } catch (\RuntimeException $e) {
            Logger::getLogger()->error($e->getMessage(), $e->getTrace());
            throw new HttpInternalServerError($e->getMessage());
        }

        return $this->get($response);
    }

}
