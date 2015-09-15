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
     * Sortable scope
     *
     * @param $query
     * @param string|null $key
     * @param string|null $direction
     * @return $query
     */
    public function scopeSortableBy($query, $key = null, $direction = null)
    {
        $direction = $this->getSortableDirection($direction);
        $key = $this->getSortableKey($key);

        return $query->orderBy($key, $direction);
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

        if (is_null($key) && property_exists($this, 'sortableKey'))
        {
            return $this->sortableKey;
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
        if (array_key_exists($key, $this->sortableColumns))
        {
            return $this->sortableColumns[$key];
        }

        return $this->getDefaultSortableKey();
    }

    /**
     * Returns the default sortable key
     *
     * @return string
     */
    protected function getDefaultSortableKey()
    {
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

        if (is_null($direction) && property_exists($this, 'sortableDirection'))
        {
            return strtolower($this->sortableDirection);
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
        if (preg_match('/(asc|desc)/', $direction = strtolower($direction)))
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
    protected function getDefaultSortableDirection()
    {
        return 'asc';
    }

}