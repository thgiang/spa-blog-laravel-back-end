<?php

namespace App;

use App\Events\SaveBlogEvent;
use Illuminate\Database\Eloquent\Model;
use App\Category;

class Blog extends Model
{
    public function category() {
        return $this->belongsTo('\App\Category', 'cat_id');
    }

    public function getIndexName() {
        return 'blogs_index';
    }

    protected $dispatchesEvents = [
        'saved' => SaveBlogEvent::class,
    ];
}
