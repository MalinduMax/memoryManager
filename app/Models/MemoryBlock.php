<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemoryBlock extends Model
{
    use HasFactory;

    protected $fillable = ['size', 'allocated', 'allocated_to'];
}
