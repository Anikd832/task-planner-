<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $table = 'days';

    // protected $fillable = [
    //     'name', 'status', 'created_by', 'updated_by'
    // ];

    public $timestamps = true;

    public function scopeActive($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Query Filter
     *
     * @param  QueryFilter $filters
     * @return Collection
     */
    // public function scopeFilter($query, QueryFilter $filters)
    // {
    //     return $filters->apply($query);
    // }
}
