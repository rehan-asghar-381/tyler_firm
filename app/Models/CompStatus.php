<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompStatus extends Model
{
    use HasFactory;

    protected $table            = 'comp_statuses';
    protected $primary_key      = 'id';

}
