<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Subject;
use App\Models\Day;
use App\Models\Teacher;
use App\Http\Filters\QueryFilter;
class Routine extends Model
{
    use HasFactory;

    protected $table = 'routines';

    protected $fillable = [
        'user_id', 'academic_setting_id', 'subject_id', 'teacher_id', 'day_id',
        'room_no', 'from', 'to', 'status', 'created_by', 'updated_by'
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    // public function academic_setting()
    // {
    //     return $this->belongsTo(User::class, 'academic_setting_id', 'id');
    // }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
    public function day()
    {
        return $this->belongsTo(Day::class , 'day_id', 'id');
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
