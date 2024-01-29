<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolutionComment extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = "solutioncomments";

    protected $fillable = [
        'user_id', 'solution_id', 'content'
    ];


 
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function solution(): BelongsTo
    {
        return $this->belongsTo(Solution::class, 'solution_id', 'id');
    }
}
