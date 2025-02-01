<?php

namespace App\Traits;

trait FilterSortSearch
{
    public function scopeFilter($query, $filters)
    {
        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, $value);
            }
        }
        return $query;
    }

    public function scopeSort($query, $sortBy, $sortOrder)
    {
        return $query->orderBy($sortBy, $sortOrder);
    }

    public function scopeSearch($query, $search, $columns)
    {
        if ($search) {
            $query->where(function ($q) use ($search, $columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }
        return $query;
    }
}
