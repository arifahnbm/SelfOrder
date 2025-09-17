<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuReview extends Model
{
    /** @use HasFactory<\Database\Factories\MenuReviewFactory> */
    use HasFactory;
    protected $fillable = ['menu_id', 'nama', 'rating', 'komentar'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
