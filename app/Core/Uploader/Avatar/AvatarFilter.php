<?php

namespace FELS\Core\Uploader\Avatar;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class AvatarFilter implements FilterInterface
{
    /**
     * Applies filter to given image
     *
     * @param  Image $image
     * @return Image
     */
    public function applyFilter(Image $image)
    {
        $size = config('avatar.max_size');
        $image->resize($size, $size, function ($constraint) {
            $constraint->upsize();
        });

        return $image;
    }
}
