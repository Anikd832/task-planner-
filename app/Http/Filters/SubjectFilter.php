<?php

namespace App\Http\Filters;

class SubjectFilter extends QueryFilter
{
    /**
     * student participants filter by type
     *
     * @param  String  $type
     * @return Query Builder
     */
    public function title($str = null)
    {
        return $this->builder->when($str != 'all', function ($q) use ($str) {
            return $q->where('title', $str);
        });
    }

    /**
     * course order by column and value
     *
     * @param  String  $str
     * @return Query Builder
     */
    public function order($str = null)
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder
            ->when($str == 'title', function ($q) {
                return $q->orderBy('title', request('direction') ?? 'asc');
            })
            ->when($str == 'start_date', function ($q) {
                return $q->orderBy('start_date', request('direction') ?? 'asc');
            });
    }

    /**
     * course search by random string
     *
     * @param  String $str
     * @return Query Builder
     */
    public function q($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where(function ($query) use ($str) {
            return $query->where('title', 'LIKE', '%' . $str . '%')
                ->orWhere('start_date',  'LIKE', '%' . $str . '%')
                ->orWhere('start_time',  'LIKE', '%' . $str . '%');
        });
    }
}
