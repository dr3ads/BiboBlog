<?php

namespace BiboBlog\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $with = ['author'];
    protected $fillable = ['title', 'content', 'user_id'];

    use SluggableTrait;

    public function author()
    {
        return $this->belongsTo('BiboBlog\Eloquent\User','user_id');
    }

    public function comments()
    {
        return $this->hasMany('BiboBlog\Eloquent\Comment');
    }
}
