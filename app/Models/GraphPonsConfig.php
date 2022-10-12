<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraphPonsConfig extends Model
{
    use HasFactory;

    /**
     * Table select
     *
     * @var string
     */
    protected $table = "graph_pon_config";

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
        "ID_OLT_GRAPH", "PORT", "NAME_GRAPH"
    ];
}
