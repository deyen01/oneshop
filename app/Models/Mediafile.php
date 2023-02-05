<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Mediafile extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function (Mediafile $mediafile) {
            if (Auth::check()) {
                $mediafile->user_id = Auth::id();
            }
        });
    }

    public function getMtAttribute()
    {
        return Storage::mimeType($this->uri);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
