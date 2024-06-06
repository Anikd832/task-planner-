<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Http\Filters\QueryFilter;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    // that measns all fields are mass-assignable, use when appropriate
    // protected $guarded = [];

    protected $fillable = [
        'user_id', 'title', 'description', 'start_date', 'start_time', 'repeat_type',
        'status', 'status', 'created_by', 'updated_by'
    ];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

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
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
