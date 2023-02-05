<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Mediafile;
use App\Models\Product;
use App\Models\User;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'parent_id',
        'picture_id'
    ];

    public function picture() {
        return $this->belongsTo(Mediafile::class);
    }

    public function parent() {
        return $this->belongsTo(self::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function user() { // пользователь - создатель
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function (Category $category) {
            if (Auth::check()) {
                $category->user_id = Auth::id();
            }
        });
    }
}
