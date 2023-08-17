<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class QuoteApproval extends Model
{
    use HasFactory;

    protected $table            = 'quote_approval';
    protected $primary_key      = 'id';

}
