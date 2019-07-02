<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Syntax extends Model
{

    protected $guarded = ['id'];

    public function pastes()
    {

    }

    public function getURLAttribute()
    {
        return $this->attributes['url'] = route('archives.single', $this->slug);
    }

    public function getFileExtensionAttribute()
    {
        if (!empty($this->extension)) {
            return $this->extension;
        } else {
            return 'txt';
        }
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
