<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ImageInterface;
use Illuminate\Support\Facades\Storage;

class Image implements ImageInterface
{
	/**
	 * Decode a base64 encoded image
	 * @param $url
	 * @return bool|string
	 */
	public function decode($url)
	{
		$image = str_replace('data:image/png;base64,', '', $url);
		$image = str_replace(' ', '+', $image);

		return base64_decode($image);
	}

	/**
	 * Save a decoded image
	 * @param $url
	 * @param $path
	 * @param $name
	 * @return int
	 */
	public function save($url, $path, $name)
	{
		$image = $this->decode($url);

		return Storage::disk('public')->put($path . '/' . $name, $image);
	}

	/**
	 * Create directory for storing image and return
	 * @param $path
	 * @return mixed
	 */
	public function location($path)
	{
		if (! Storage::disk('public')->exists($path)) {
			Storage::disk('public')->makeDirectory($path, $recursive = true);
		}

		return $path;
	}
}
