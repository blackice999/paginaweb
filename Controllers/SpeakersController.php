<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 24.05.2017
 * Time: 20:03
 */

namespace Controllers;


use Utils\HTMLGenerator;
use Utils\StringUtils;

class SpeakersController implements Controller
{

    private $categories = ["portable_speakers"];
    const PORTABLE_SPEAKERS_CATEGORY_ID = 35;

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
}