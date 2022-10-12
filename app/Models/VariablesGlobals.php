<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariablesGlobals extends Model
{
    use HasFactory;

    /**
     * Table select
     *
     * @var string
     */
    protected $table = "global_variables";

     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name", "values", "id_user"
    ];
}
