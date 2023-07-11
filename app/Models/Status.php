<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Status extends Model
{
    use HasFactory;

    protected $table            = 'order_statuses';
    protected $primary_key      = 'id';

}
