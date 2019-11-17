<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'phone', 'address'];
    protected $casts = ['phone'=> 'array'];
    protected  $appends = ['allPhones'];

    public function getallPhonesAttribute()
    {
        return implode('-', array_filter($this->phone));
    }

}
