<?php

use Illuminate\Database\Eloquent\Model;
use Kenarkose\Sortable\Sortable;

class InvalidItem extends Model {

    use Sortable;

    protected $table = 'sortable_items';

    protected $fillable = ['title'];

}