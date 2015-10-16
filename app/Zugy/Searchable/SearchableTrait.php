<?php

namespace Zugy\Searchable;

use Illuminate\Database\Eloquent\Builder;

trait SearchableTrait
{
    use \Nicolaslopezj\Searchable\SearchableTrait;

    public function scopeSearchRestricted(Builder $q, $search, $restriction, $threshold = null, $entireText = false)
    {
        $query = clone $q;
        $query->select('*');
        $this->makeJoins($query);

        if ( ! $search)
        {
            return $q;
        }

        $search = mb_strtolower(trim($search));
        $words = explode(' ', $search);

        $selects = [];
        $this->search_bindings = [];
        $relevance_count = 0;

        foreach ($this->getColumns() as $column => $relevance)
        {
            $relevance_count += $relevance;
            $queries = $this->getSearchQueriesForColumn($query, $column, $relevance, $words);

            if ( $entireText === true )
            {
                $queries[] = $this->getSearchQuery($query, $column, $relevance, [$search], 30, '', '%');
            }

            foreach ($queries as $select)
            {
                $selects[] = $select;
            }
        }

        $this->addSelectsToQuery($query, $selects);

        // Default the threshold if no value was passed.
        if (is_null($threshold)) {
            $threshold = $relevance_count / 4;
        }

        $this->filterQueryWithRelevance($query, $selects, $threshold);

        $this->makeGroupBy($query);

        $this->addBindingsToQuery($query, $this->search_bindings);

        if(is_callable($restriction)) {
            $query = $restriction($query);
        }

        $q->where('locale', '=', app()->getLocale());

        $this->mergeQueries($query, $q);

        return $q;
    }
}