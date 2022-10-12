<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportDBTask extends Model
{
    use HasFactory;

    /**
     * Table select
     *
     * @var string
     */
    protected $table = "import_db_task";

     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name_file", "path", "id_user", "finished"
    ];
}
