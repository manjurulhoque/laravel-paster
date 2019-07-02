<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paste extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function language()
    {
        return $this->hasOne(Syntax::class, 'slug', 'syntax');
    }

    public function getCreatedAgoAttribute()
    {
        return $this->attributes['created_ago'] = $this->created_at->diffForHumans();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getTitleAttribute()
    {
        return (!empty($this->title)) ? $this->title : 'Untitled';
    }

    public function getURLAttribute()
    {
        return route('paste.show', $this->slug);
    }

    public function getContentAttribute()
    {
        return $this->encrypt ? decrypt($this->attributes['content']) : html_entity_decode($this->attributes['content']);
    }

    public function getContentSizeAttribute()
    {
        return $this->attributes['content_size'] = number_format(strlen($this->content) / 1000, 2);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
