<?php

namespace Chebaby\LaravelSearchable\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Chebaby\LaravelSearchable\Searchable;

class User extends Model
{
    use Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
