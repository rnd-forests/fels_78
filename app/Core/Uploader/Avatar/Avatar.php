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
        $directory = $this->generateAvatarDirectory();
        File::exists($directory) || File::makeDirectory($directory);

        $path = "{$directory}{$this->constructAvatarName()}";
        $this->updateAvatarAttribute($path);

        return $this->saveNewAvatar($path);
    }

    /**
     * Change the value of avatar attribute for the user.
     *
     * @param $path
     * @return bool|int
     */
    protected function updateAvatarAttribute($path)
    {
        $relativePath = clear_pattern(public_path(), $path);

        return $this->user->update(['avatar' => $relativePath]);
    }

    /**
     * Apply avatar filter and save new avatar for user.
     *
     * @param $path
     * @return \Intervention\Image\Image
     */
    protected function saveNewAvatar($path)
    {
        return Image::cache(function ($cache) use ($path) {
            $cache->make($this->getUploadedFilePath())
                ->filter(new AvatarFilter)
                ->save($path);
        }, config('avatar.cache_time'), true);
    }

    /**
     * Get the directory to save new avatar.
     *
     * @return string
     */
    protected function generateAvatarDirectory()
    {
        return config('avatar.base_directory') . $this->user->slug . '/';
    }

    /**
     * Get the name of the uploaded photo.
     * Hashed value of user's email.
     *
     * @return string
     */
    protected function constructAvatarName()
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
