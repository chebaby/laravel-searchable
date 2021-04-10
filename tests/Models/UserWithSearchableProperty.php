<?php

namespace Chebaby\LaravelSearchable\Tests\Models;

class UserWithSearchableProperty extends User
{
    /**
     * Searchable attributes
     *
     * @return string[]
     */
    public $searchable = ['name', 'email'];
}
