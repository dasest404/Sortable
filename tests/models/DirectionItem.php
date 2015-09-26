<?php

use Illuminate\Database\Eloquent\Model;
use Kenarkose\Sortable\Sortable;

class DirectionItem extends Model {

    use Sortable;

    public $sortableColumns = ['title', 'created_at'];

    protected $table = 'sortable_items';

    protected $fillable = ['title'];

    protected $sortableDirection = 'DESC';

}