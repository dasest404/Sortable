<?php

use Illuminate\Database\Eloquent\Model;
use Kenarkose\Sortable\Sortable;

class DirectionItem extends Model {

    use Sortable;

    public $sortableColumns = [
        'name' => 'title',
        'date' => 'created_at'
    ];

    protected $table = 'sortable_items';

    protected $fillable = ['title'];

    protected $sortableDirection = 'DESC';

}