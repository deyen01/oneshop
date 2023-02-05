<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'category_id',
        'picture_id'
    ];

    public function picture() {
        return $this->belongsTo(Mediafile::class);
    }

    public function user() // Пользователь, который добавил товар
    {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function favusers() // пользователи, у которых товар в Избранном
    {
        return $this->belongsToMany(User::class, 'user_product');
    }

    protected static function booted()
    {
        static::creating(function (Product $product) {
            if (Auth::check()) {
                $product->user_id = Auth::id();
            }
        });
    }
}
