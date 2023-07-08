<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class ClientMeasurement extends Model
{
    protected $table    = 'client_measurements';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'country',
        'title',
        'field1_hb',
        'field2_b',
        'field3_w',
        'field4_hh',
        'field5_h',
        'field6_sh',
        'field7_half_sh',
        'field8_sh_w',
        'field9_sh_kn',
        'field10_sh_g',
        'field11_w_kn',
        'field12_w_g',
        'field13_arm',
        'field14_half_arm',
        'field15_arm_depth',
        'field16_bicep',
        'field17_wrist',
        'field18_sh_w',
        'field19_tw',
        'field20_sh_hh',
        'measurement_type',
        'created_by_id',
        'created_by_name',
        'updated_by_id',
        'updated_by_name'
    ];

    public function Client(){
        
        return $this->belongsto(Client::class, "client_id", "id");
    }

}
