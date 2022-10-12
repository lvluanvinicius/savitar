<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AverageDBM extends Model
{
    use HasFactory;

    /**
     * Table select
     *
     * @var string
     */
    protected $table = "pons_average_dbm";

     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

}
