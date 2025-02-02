<?php

namespace App\Traits;

trait BaseModel
{
    public function scopeSearch($query, $search, $columns = ['name'])
    {
        if (!empty($search)) {
            $query->where(function ($q) use ($search, $columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'LIKE', "%{$search}%");
                }
            });
        }
        return $query;
    }

    public function scopeSort($query, $column = 'created_at', $direction = 'desc')
    {
        return $query->orderBy($column, $direction);
    }

    public function scopeFilter($query, $filters = [])
    {
        foreach ($filters as $column => $value) {
            if (!empty($value)) {
                $query->where($column, $value);
            }
        }
        return $query;
    }
}
