<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade',
        'text',
        'product_id',
    ];

    public function product() // Товар, к которому относится коммент
    {
        return $this->belongsTo(Product::class);
    }

    public function user() // Пользователь, который добавил коммент
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function (Comment $comment) {
            if (Auth::check()) {
                $comment->user_id = Auth::id();
            }
        });
    }
}
