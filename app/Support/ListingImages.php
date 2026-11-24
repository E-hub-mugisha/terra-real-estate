<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

/**
 * Listing photos live in public/{dir}/{image_path} (e.g. public/image/houses/abc.jpg).
 * One place to store, zip and delete them so admin and agent screens behave the same.
 */
class ListingImages
{
    /**
     * Save uploaded files into public/{dir} and create a related image row for each.
     *
     * @param  UploadedFile[]  $files
     * @param  callable(string $filename): Model  $create
     */
    public static function store(array $files, string $dir, callable $create): int
    {
        $path = public_path(trim($dir, '/'));
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $count = 0;
        foreach ($files as $file) {
            if (!$file instanceof UploadedFile || !$file->isValid()) {
                continue;
            }
            $filename = time() . '_' . Str::random(10) . '.' . strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $file->move($path, $filename);
            $create($filename);
            $count++;
        }

        return $count;
    }

    /**
     * Build a ZIP of all photos that still exist on disk.
     * Returns null when there is nothing to download.
     */
    public static function zip(Collection $images, string $dir, string $name): ?BinaryFileResponse
    {
        $files = $images
            ->map(fn ($img) => public_path(trim($dir, '/') . '/' . $img->image_path))
            ->filter(fn ($file) => is_file($file))
            ->values();

        if ($files->isEmpty() || !class_exists(ZipArchive::class)) {
            return null;
        }

        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zipName = Str::slug($name) . '-photos.zip';
        $zipPath = $tempDir . DIRECTORY_SEPARATOR . Str::random(8) . '-' . $zipName;

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return null;
        }
        foreach ($files as $i => $file) {
            $zip->addFile($file, sprintf('photo-%02d.%s', $i + 1, pathinfo($file, PATHINFO_EXTENSION)));
        }
        $zip->close();

        return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
    }

    /** Delete one image row and its file. */
    public static function delete(Model $image, string $dir): void
    {
        $file = public_path(trim($dir, '/') . '/' . $image->image_path);
        if (is_file($file)) {
            @unlink($file);
        }
        $image->delete();
    }
}
