<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    public function __construct(private readonly string $targetDirectory) {

    }

    public function upload(UploadedFile $file): string
    {
        $fileName = uniqid() . '.' . $file->guessExtension();

        try {
            // déplace
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // handle de l'exception
        }
        return $fileName;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    public function delete(?string $fileName, string $rep): void
    {
        $filePath = $rep . '/' . $fileName;
        if(null != $fileName && file_exists($filePath)) {
            unlink($filePath);
        }
    }

}