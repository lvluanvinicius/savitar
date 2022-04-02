<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupsRelated extends Model
{
    use HasFactory;

    /**
     * Reference table
     *
     * @var string
     */
    protected $table = "users_groups_related";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id_user", "id_group_users"
    ];


    /**
     * Timestamp config.
     *
     * @var boolean
     */
    public $timestamps = false;
}
