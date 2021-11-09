<?php

namespace App\Service;

use App\Model\TagManager;

class ColorGenerator
{
    private $colors =  ['primary', 'secondary', 'danger', 'warning', 'info', 'dark', 'success'];

    public function generateTagsWithColor(array $tags = [])
    {
        $tagManager = new TagManager();
        $tags = [];
        $tagsToFill = empty($tags) ? $tagManager->selectAll() : $tags;
        $colors = $this->colors;
        shuffle($colors);
        foreach ($tagsToFill as $tag) {
            $tag['color'] = $colors[rand(0, (count($colors) - 1))];
            $tags[] = $tag;
        }
        return $tags;
    }
}
