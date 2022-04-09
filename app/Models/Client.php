<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Client extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $appends = [
        'photo',
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getPhotoAttribute()
    {
        $file = $this->getMedia('photo')->last();

        if ($file) {
            $file->url       = $file->getUrl();
        }

        return $file;
    }
}
