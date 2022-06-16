<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SiteConfig extends Model
{
    use HasFactory;
    protected $table = 'site_config';
    protected $fillable = [
        'type',
        'field_key',
        'field_value',
        'status',
    ];
}
