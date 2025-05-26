<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'meta_title',
        'meta_description',
        'published_at',
        'is_published',
        'user_id',
        'category_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    /**
     * Boot the model and add event listeners for auto-generating slugs.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug) && ! empty($post->title)) {
                $post->slug = static::generateUniqueSlug($post->title);
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && (empty($post->slug) || $post->slug === static::generateSlugFromTitle($post->getOriginal('title')))) {
                $post->slug = static::generateUniqueSlug($post->title);
            }
        });
    }

    /**
     * Generate a unique slug for the post.
     */
    protected static function generateUniqueSlug($title, $id = null)
    {
        $baseSlug = static::generateSlugFromTitle($title);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->when($id, function ($query, $id) {
            return $query->where('id', '!=', $id);
        })->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Generate a slug from a title.
     */
    protected static function generateSlugFromTitle($title)
    {
        return Str::slug($title);
    }

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the post.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the tags for the post.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
