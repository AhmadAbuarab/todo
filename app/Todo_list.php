<?php


namespace App;
use Illuminate\Database\Eloquent\Model;


class Todo_list extends Model  {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'todo_list';
    protected $fillable = ['name', 'description', 'date', 'status', 'category'];

}