<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\QueryFilter;

class UserProfile extends Model
{
    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id', 'dob', 'gender', 'religion', 'present_address', 'permanent_address', 'created_by'
    ];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
