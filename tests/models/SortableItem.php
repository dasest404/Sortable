<?php

use Illuminate\Database\Eloquent\Model;
use Kenarkose\Sortable\Sortable;

class SortableItem extends Model {

    use Sortable;

    public $sortableColumns = ['title', 'created_at'];

    protected $fillable = ['title'];

}