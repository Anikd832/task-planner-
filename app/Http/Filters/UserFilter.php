<?php

namespace App\Http\Filters;

class UserFilter extends QueryFilter
{
    /**
     * student participants filter by type
     *
     * @param  String  $type
     * @return Query Builder
     */
    public function status($str = null)
    {
        $str = strtolower($str);
        return $this->builder->when($str != 'all', function ($q) use ($str) {
            return $q->where('status', $this->getStatusCode($str));
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
            return $this->builder;
        }
        return $this->builder
            ->when($str == 'name', function ($q) {
                return $q->orderBy('full_name', request('direction') ?? 'asc');
            })
            ->when($str == 'email', function ($q) {
                return $q->orderBy('email', request('direction') ?? 'asc');
            })
            ->when($str == 'contact', function ($q) {
                return $q->orderBy('contact', request('direction') ?? 'asc');
            })
            ->when($str == 'status', function ($q) {
                return $q->orderBy('status', request('direction') ?? 'asc');
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
            return $this->builder;
        }
        return $this->builder->where(function ($query) use ($str) {
            return $query->where('full_name', 'LIKE', '%' . $str . '%')
                ->orWhere('email',  'LIKE', '%' . $str . '%')
                ->orWhere('contact',  'LIKE', '%' . $str . '%');
        });
    }

    /**
     * get status code by name
     */
    protected function getStatusCode($status)
    {
        return [
            'active' => '1',
            'inactive' => '2',
        ][strtolower($status)] ?? null;
    }
}
