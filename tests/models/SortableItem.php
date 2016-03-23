<?php

use Illuminate\Database\Eloquent\Model;
use Kenarkose\Sortable\Sortable;

class SortableItem extends Model {

    use Sortable;

    public $sortableColumns = ['title', 'created_at', 'special_key'];

    public $specialSortableKeys = ['special_key' => 'specialFunction'];

    protected $fillable = ['title'];

    public function specialFunction($query, $key, $direction)
    {
        throw new \Exception($key);
    }

}