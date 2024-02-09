<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'city', 'state','status'];

    public function rules(){
        return 
        [ 
            'name' => 'required',
            'slug' => 'required',
            'city' => 'required',
            'state' => 'required',
        ];
    }

    public function feedback(){
        return 
        [
            'required' => 'input name required',
            'required' => 'input slug required',
            'required' => 'input city required',
            'required' => 'input state required',
        ];
    }
}
