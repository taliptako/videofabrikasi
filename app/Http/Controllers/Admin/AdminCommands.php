<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;

class AdminCommands extends Controller
{
    public function delete_storage()
    {
        $directories = Storage::disk('public')->directories();
        foreach ($directories as $directory)
        {
            Storage::disk('public')->deleteDirectory($directory);
        }

        return view('admin.dashboard');
    }
}
