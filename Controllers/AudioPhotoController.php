<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 13.04.2017
 * Time: 17:32
 */

namespace Controllers;


use Utils\HTMLGenerator;
use Utils\StringUtils;

class AudioPhotoController implements Controller
{

    private $categories = ["speakers", "portable_speakers", "microphones", "cameras", "d_slr", "compact", "bridge"];
    const SPEAKERS_CATEGORY_ID = 31;
    const MICROPHONES_CATEGORY_ID = 32;
    const CAMERAS_CATEGORY_ID = 33;

    public function get()
    {
        if (isset($_GET['path']) && $_GET['path'] !== "audio_photo") {
            $this->{$_GET['path']}($_GET['path']);
        } else {
            foreach ($this->categories as $category) {
                $titleFromLink = StringUtils::removeUnderscore($category);
                HTMLGenerator::tag("h3", ucfirst($titleFromLink));
                echo HTMLGenerator::link($category, "Check all " . $titleFromLink);
            }
        }
    }

    public function post()
    {
        // TODO: Implement post() method.
    }

    public function __call($name, $arguments)
    {
        echo $name;
    }
}