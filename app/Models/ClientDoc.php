<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDoc extends Model
{
    use HasFactory;

    protected $table            = 'client_docs';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'doc'
    ];

    public function Client(){

        return $this->belongsTo(Client::class, 'id','client_id');
    }


}
