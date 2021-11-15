<?php

namespace App\Service;

use App\Model\TagManager;

class ColorGenerator
{
    private $colors =  ['primary', 'secondary', 'danger', 'warning', 'info', 'dark', 'success'];

    public function generateTagsWithColor(array $tags = [])
    {
        $tagManager = new TagManager();
        $tagsToFill = count($tags) === 0 ? $tagManager->selectAll() : $tags;
        $colors = $this->colors;
        shuffle($colors);
        $results = [];
        foreach ($tagsToFill as $tag) {
            $tag['color'] = $colors[rand(0, (count($colors) - 1))];
            $results[] = $tag;
        }
        return $results;
    }
}
