<?php

namespace App\Repositories\Interfaces;

interface ImageInterface
{
    public function decode($url);
    public function save($url, $path, $name);
    public function location($path);
}