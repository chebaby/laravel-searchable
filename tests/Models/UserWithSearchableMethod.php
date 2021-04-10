<?php

namespace Chebaby\LaravelSearchable\Tests\Models;

class UserWithSearchableMethod extends User
{
    /**
     * Searchable attributes
     *
     * @return string[]
     */
    public static function searchable()
    {
        return ['name', 'email'];
    }
}
