<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Post extends Model
{
    protected $dates = ['created_at'];
    protected $fillable = ['body','title'];
    protected $appends = ['image'];
    protected $visible = ['_id', 'title', 'body', 'author', 'created_at', 'image'];

    public function author()
    {
        return $this->belongsTo('App\User');
    }

    public function getImageAttribute() : string
    {
        return "https://picsum.photos/400/300/?$this->_id";
    }
}


