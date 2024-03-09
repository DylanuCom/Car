<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    // الحقول التي يمكن ملؤها في النموذج
    protected $fillable = ['title', 'video', 'price', 'images', 'specifications'];

    // تحويل البيانات من وإلى نوع JSON
    protected $casts = [
        'images' => 'json',
        'specifications' => 'json',
    ];
}
