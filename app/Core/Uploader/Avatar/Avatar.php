<?php

namespace FELS\Core\Uploader\Avatar;

use File;
use Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Avatar
{
    protected $user;
    protected $file;

    public function __construct($user, UploadedFile $file)
    {
        $this->user = $user;
        $this->file = $file;
    }

    /**
     * Create user's avatar.
     *
     * @return \Intervention\Image\Image
     */
    public function make()
    {
        $directory = $this->getPhotoDirectory();
        File::exists($directory) || File::makeDirectory($directory);

        $path = $this->getPhotoDirectory() . $this->getPhotoName();
        $relativePath = clear_pattern(public_path(), $path);

        $this->user->update(['avatar' => $relativePath]);

        return Image::cache(function ($imageCache) use ($path) {
            $imageCache->make($this->getUploadedFilePath())
                ->filter(new AvatarFilter)
                ->save($path);
        }, config('avatar.cache_time'), true);
    }

    /**
     * Get the directory to save new avatar.
     *
     * @return string
     */
    protected function getPhotoDirectory()
    {
        return config('avatar.base_directory') . $this->user->slug . '/';
    }

    /**
     * Get the name of the uploaded photo.
     * Hashed value of user's email.
     *
     * @return string
     */
    protected function getPhotoName()
    {
        $name = md5($this->user->email);
        $extension = $this->file->getClientOriginalExtension();

        return "{$name}.{$extension}";
    }

    /**
     * Get the real path of the uploaded file.
     *
     * @return string
     */
    protected function getUploadedFilePath()
    {
        return $this->file->getRealPath();
    }
}
