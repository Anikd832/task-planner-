<?php

namespace App\Models;

use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $fillable = [
        'title', 'code', 'credit', 'subject_type', 'status', 'created_by', 'updated_by'
    ];

    public $timestamps = true;

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Query Filter
     *
     * @param  QueryFilter $filters
     * @return Collection
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
