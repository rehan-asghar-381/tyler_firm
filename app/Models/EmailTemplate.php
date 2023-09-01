<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $table    = 'email_templates';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time_id',
        'name',
        'description',
        'created_by_id',
        'created_by_name',
        'updated_by_id',
        'updated_by_id'
    ];
    
}
