<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StorageFileController extends Controller
{
    /**
     * Serve a file from the "public" storage disk directly through Laravel.
     *
     * This exists as a safety net for environments where `php artisan
     * storage:link` was never run or couldn't create the symlink (a common
     * issue on Windows, where creating symlinks requires Developer Mode or
     * an elevated terminal). When the symlink DOES exist, the web server
     * serves the file directly and this route is never reached, so it's
     * always safe to have this fallback in place.
     */
    public function show(string $path): StreamedResponse
    {
        abort_unless(Storage::disk('public')->exists($path), 404);

        return Storage::disk('public')->response($path);
    }
}
