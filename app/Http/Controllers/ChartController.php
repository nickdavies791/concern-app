<?php

namespace App\Http\Controllers;

use App\Tag;

class ChartController extends Controller
{
    public function totalConcernsByTag(Tag $tag)
    {
        $tags = $tag->withCount('concerns')->get()->mapWithKeys(function ($item) {
                return [$item->name => $item->concerns_count];
            });;
        $data = [
            'labels' => $tags->keys()->all(),
            'data' => $tags->values()->all()
        ];
        return $data;
    }
}
