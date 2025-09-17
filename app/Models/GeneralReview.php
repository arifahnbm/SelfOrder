<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralReview extends Model
{
    /** @use HasFactory<\Database\Factories\GeneralReviewFactory> */
    use HasFactory;
    protected $fillable = ['nama', 'komentar'];
}
