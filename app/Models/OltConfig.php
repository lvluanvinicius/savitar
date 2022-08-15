<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OltConfig extends Model
{
    use HasFactory;

    /**
     * Table select
     *
     * @var string
     */
    protected $table = "olt_config";

     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
