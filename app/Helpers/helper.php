<?php

if (!function_exists('storage_folder_subfolder')) {
    function storage_folder_subfolder($folderA, $folderB, $file) {
        $path = storage_path('app/public/'.$folderA.'/'.$folderB.'/'.$file);
        abort_unless(File::exists($path), 404);
        return response()->make(File::get($path), 200)->header('Content-Type', File::mimeType($path));
    }
}

if (!function_exists('storage_folder')) {
    function storage_folder($folder, $file) {
        $path = storage_path('app/public/'.$folder.'/'.$file);
        abort_unless(File::exists($path), 404);
        return response()->make(File::get($path), 200)->header('Content-Type', File::mimeType($path));
    }
}