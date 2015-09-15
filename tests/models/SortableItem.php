<?php

use Illuminate\Database\Eloquent\Model;
use Kenarkose\Sortable\Sortable;

class SortableItem extends Model {

    use Sortable;

    public $sortableColumns = [
        'name' => 'title',
        'date' => 'created_at'
    ];

    protected $fillable = ['title'];

}