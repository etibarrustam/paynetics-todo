<?php

namespace App\Models\Traits;

use App\Models\Enums\SearchableRelation;
use DB;
use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Selected columns for search.
     * @var array
     */
    private array $searchColumns = [];

    /**
     * Declare Model's searchable columns.
     * @var array[]
     */
    public array $searchable = [];

    /**
     * Search method for Models.
     * @param Builder $query
     * @param string|null $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search = null): Builder
    {
        if ($search) {
            if (! property_exists($this, 'searchable')) {
                $this->searchable = $this->fillable;
            }

            $selects = [$this->getTable().'.*'];

            if ($query->getQuery()->columns) {
                $selects = array_replace(
                    $query->getQuery()->columns,
                    ['*'],
                    [$this->getTable().'.*']
                );
            }

            $query->getQuery()->select($selects);

            foreach ($this->searchable as $key => $column) {
                if (is_int($key)) {
                    $this->searchColumns[] = $this->getTable().'.'.$column;
                }
                if ($key === SearchableRelation::RELATIONS->value) {
                    $this->addRelatedFieldsToSearch($query, $column);
                }
            }

            $query->distinct();

            $columns = implode(', ', $this->searchColumns);
            $search = strip_tags($search);

            $query->where(DB::raw("CONCAT_WS(' ',${columns})"), 'LIKE', "%${$search}%");
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param array $relations
     * @return Builder
     */
    private function addRelatedFieldsToSearch(Builder $query, array $relations): Builder
    {
        foreach ($relations as $table => $details) {
            [$firstTableKey, $secondTableKey, $field] = $details;

            if (! is_array($field)) {
                $field = [$field];
            }
            if (! $query->isTableJoined($table)) {
                $query->leftJoin($table, $firstTableKey, '=', $secondTableKey);
            }

            foreach ($field as $relatedField) {
                $this->searchColumns[] = $relatedField;
            }

            if (! empty($details[SearchableRelation::RELATIONS->value])) {
                $this->addRelatedFieldsToSearch($query, $details[SearchableRelation::RELATIONS->value]);
            }
        }

        return $query;
    }
}
