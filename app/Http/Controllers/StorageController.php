<?php

namespace App\Http\Controllers;

class StorageController extends Controller
{
    public function addToSubFolder($folderA, $folderB, $file)
    {
        return storage_folder_subfolder($folderA, $folderB, $file);
    }

    public function addToFolder($folder, $file){
        return storage_folder($folder, $file);
    }
}
