<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use SoftDeletes;
    
    protected $fillable = [
        'title',
        'description',
        'content',
        'image',
        'publish_at',
        'category_id'
    ];
    /**
     * Delete post image from stroage
     * 
     * @return void
     */

    public function deleteImage()
    {
        Storage::delete($this->image);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
