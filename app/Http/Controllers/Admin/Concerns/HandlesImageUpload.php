<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HandlesImageUpload
{
    /**
     * Resolve the final `image_url` value for a request that may contain
     * either an uploaded file (`image`) or a plain URL string (`image_url`).
     *
     * - If a new file was uploaded, it is stored on the public disk and its
     *   public URL replaces `image_url`.
     * - If no file was uploaded, the submitted `image_url` (or the existing
     *   value when editing) is kept as-is.
     *
     * @param  string  $folder  Storage sub-folder, e.g. "carousel", "actualites"
     * @param  string|null  $existingUrl  Current image_url when editing (used to delete the old file if replaced)
     */
    protected function resolveImageUrl(Request $request, string $folder, ?string $existingUrl = null): ?string
    {
        if ($request->hasFile('image')) {
            // Remove the previous locally-stored file if we're replacing it,
            // to avoid piling up orphaned uploads on disk.
            if ($existingUrl) {
                $this->deleteLocalImageIfOwned($existingUrl);
            }

            $path = $request->file('image')->store($folder, 'public');

            return Storage::disk('public')->url($path);
        }

        return $request->input('image_url', $existingUrl);
    }

    /**
     * Delete a previously-uploaded local file if the given URL points to our
     * own public storage disk (never attempts to delete external URLs).
     */
    protected function deleteLocalImageIfOwned(?string $url): void
    {
        if (! $url) {
            return;
        }

        $storageUrlPrefix = Storage::disk('public')->url('');

        if (! str_starts_with($url, $storageUrlPrefix)) {
            return;
        }

        $relativePath = ltrim(substr($url, strlen($storageUrlPrefix)), '/');

        if ($relativePath && Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
