<?php

use Illuminate\Database\Eloquent\Model;
use Kenarkose\Sortable\Sortable;

class KeyItem extends Model {

    use Sortable;

    public $sortableColumns = ['title', 'created_at'];

    protected $table = 'sortable_items';

    protected $fillable = ['title'];

    protected $sortableKey = 'title';

}