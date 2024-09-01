<?php

namespace App\Models\Traits;

use App\Models\File;

trait HasFiles
{
    /**
     * Get all of the files for the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
