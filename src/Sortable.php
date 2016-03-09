<?php

namespace Kenarkose\Sortable;


trait Sortable {

    /**
     * Boots the trait
     */
    public static function bootSortable()
    {
        if ( ! property_exists(get_called_class(), 'sortableColumns'))
        {
            throw new \RuntimeException('The sortableColumns property is not set.');
        }
    }

    /**
     * Sortable by scope
     *
     * @param $query
     * @param string|null $key
     * @param string|null $direction
     * @return $query
     */
    public function scopeSortable($query, $key = null, $direction = null)
    {
        list($key, $direction) = $this->validateSortableParameters($key, $direction);

        return $query->orderBy($key, $direction);
    }

    /**
     * Validates sortable parameters
     *
     * @param $key
     * @param $direction
     * @return array
     */
    protected function validateSortableParameters($key, $direction)
    {
        if (is_null($key))
        {
            // We are using the facade here instead of the request helper
            // to make this package compatible with Laravel 5.0
            $key = \Request::input(Supporter::keyName);
        }

        if (is_null($direction))
        {
            $direction = \Request::input(Supporter::directionName);
        }

        $direction = $this->getSortableDirection($direction);
        $key = $this->getSortableKey($key);

        $this->setSupporterParams($key, $direction);

        return array($key, $direction);
    }

    /**
     * Associates current sortable parameters with supporter
     *
     * @param string $key
     * @param string $direction
     */
    protected function setSupporterParams($key, $direction)
    {
        app('sortable.supporter')->setParams($key, $direction);
    }

    /**
     * Returns default key if isset or validates key
     *
     * @param string|null $key
     * @return string
     */
    public function getSortableKey($key = null)
    {
        if ( ! is_null($key))
        {
            return $this->determineSortableKey($key);
        }

        return $this->getDefaultSortableKey();
    }

    /**
     * Determines the sortable key from the map
     *
     * @param string $key
     * @return string
     */
    protected function determineSortableKey($key)
    {
        if (in_array($key, $this->sortableColumns))
        {
            return $key;
        }

        return $this->getDefaultSortableKey();
    }

    /**
     * Returns the default sortable key
     *
     * @return string
     */
    public function getDefaultSortableKey()
    {
        if (property_exists($this, 'sortableKey'))
        {
            return $this->sortableKey;
        }

        return $this->getKeyName();
    }

    /**
     * Returns default direction if isset or validates direction
     *
     * @param string|null $direction
     * @return string
     */
    public function getSortableDirection($direction = null)
    {
        if ( ! is_null($direction))
        {
            return $this->validateSortableDirection($direction);
        }

        return $this->getDefaultSortableDirection();
    }

    /**
     * Determines the sortable key from the map
     *
     * @param string $direction
     * @return string
     */
    protected function validateSortableDirection($direction)
    {
        if (preg_match('/(asc|desc)/', $direction = mb_strtolower($direction)))
        {
            return $direction;
        }

        return $this->getDefaultSortableDirection();
    }

    /**
     * Returns the default sortable direction
     *
     * @return string
     */
    public function getDefaultSortableDirection()
    {
        if (property_exists($this, 'sortableDirection'))
        {
            return strtolower($this->sortableDirection);
        }

        return 'asc';
    }

}