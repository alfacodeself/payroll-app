<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    public function upload($file, $name, $path = 'public/img')
    {
        $name = $this->generateUniqueName($name) . '.' . $file->getClientOriginalExtension();
        $storePath = $this->storeFile($file, $name, $path);
        return Storage::url($storePath);
    }

    protected function storeFile($file, $name, $path)
    {
        return $file->storeAs($path, $name);
    }

    protected function generateUniqueName(string $name)
    {
        return Str::slug($name) . '-' . now()->format('Y-m-d-his') . '-' . rand(10000, 99999);
    }

    public function remove($path)
    {
        $filePath = str_replace(url('storage'), 'public', $path);
        return Storage::delete($filePath);
    }
}
