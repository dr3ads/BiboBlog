<?php

namespace BiboBlog\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['content', 'blog_id', 'user_id'];

    public function author()
    {
        return $this->belongsTo('BiboBlog\Eloquent\User','user_id');
    }
}
