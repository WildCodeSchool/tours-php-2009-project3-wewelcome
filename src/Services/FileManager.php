<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

class FileManager
{

    /** this method take an uploaded file, it's original name and a folder where save it, as parameters
     *  the original file name is transform for a better one
     *  and then the file is save in the folder
     *  it return an error if the upload gone wrong and the newFileName of the file
     * @return array<string>
     */
    public function saveFile(string $fileName, UploadedFile $file, string $folder): array
    {
        $error = '';

        $modifiedName = $this->getNewFileName($fileName);

        if ($modifiedName === null) {
            $modifiedName = 'file';
        }

        $newFileName = $modifiedName . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move(
                $folder,
                $newFileName
            );
        } catch (FileException $e) {
            $error = 'Le fichier n\'a pas pu être ajouté.';
        }

        return ['error' => $error, 'fileName' => $newFileName];
    }

    public function deleteFile(string $fileName, string $folder): void
    {
        $filesystem = new Filesystem();
        $path = $folder . $fileName;
        $filesystem->remove($path);
    }

    public function getNewFileName(string $oldName, string $delimiter = '-'): ?string
    {
        $newName = iconv('UTF-8', 'ASCII//TRANSLIT', $oldName);

        if ($newName != null) {
            $newName = preg_replace('/[\']/', '', $newName);

            if ($newName != null) {
                $newName = preg_replace('/[&]/', 'and', $newName);

                if ($newName != null) {
                    $newName = preg_replace('/[^A-Za-z0-9-]+/', $delimiter, $newName);

                    if ($newName != null) {
                        $newName = preg_replace('/[\s-]+/', $delimiter, $newName);

                        if ($newName != null) {
                            $newName = trim($newName, $delimiter);

                            if ($newName != null) {
                                $newName = trim($newName, $delimiter);

                                $newName = strtolower($newName);

                                return $newName;
                            }
                        }
                    }
                }
            }
        }

        return null;
    }
}
