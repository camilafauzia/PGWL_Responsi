<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Polygons extends Model
{
    use HasFactory;

    protected $table = 'polygons';

    // protected $fillable = [
    //     'name',
    //     'description',
    //     'geom'
    // ];

    protected $guarded = ['id'];

    public function polygons()
    {
        return $this->select(DB::raw('id, name, description, image, ST_AsGeoJSON(geom) as geom, created_at, updated_at'))->get();
    }

    public function polygon($id)
    {
        return $this->select(DB::raw('id, name, description, image, ST_AsGeoJSON(geom) as geom,created_at, updated_at'))->where('id', $id)->get();
    }
}
