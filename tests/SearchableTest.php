<?php

namespace Chebaby\LaravelSearchable\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Chebaby\LaravelSearchable\Tests\Models\User;
use Chebaby\LaravelSearchable\LaravelSearchableServiceProvider;
use Chebaby\LaravelSearchable\Tests\Models\UserWithSearchableMethod;
use Chebaby\LaravelSearchable\Tests\Models\UserWithSearchableProperty;

class SearchableTest extends TestCase
{
    use WithFaker;

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [LaravelSearchableServiceProvider::class];
    }

    /** @test */
    public function it_can_search_for_a_term_in_multiple_attributes()
    {
        User::create([
            'name' => 'john doe',
            'email' => 'john@doe.com'
        ]);

        $user = User::search('john', ['name', 'email'])->first();

        $this->assertEquals('john doe', $user->name);
        $this->assertEquals('john@doe.com', $user->email);
    }

    /** @test */
    public function it_can_search_in_multiple_attributes_for_a_term()
    {
        User::create([
            'name' => 'jane doe',
            'email' => 'jane@doe.com'
        ]);

        $user = User::search(['name', 'email'], 'jane')->first();

        $this->assertEquals('jane doe', $user->name);
        $this->assertEquals('jane@doe.com', $user->email);
    }

    /** @test */
    public function it_can_search_for_a_term_without_passing_attributes_using_searchable_property()
    {
        UserWithSearchableProperty::create([
            'name'  => 'Johnny doe',
            'email' => 'Johnny@doe.com'
        ]);

        $user = UserWithSearchableProperty::search('johnny')->first();

        $this->assertEquals('Johnny doe', $user->name);
        $this->assertEquals('Johnny@doe.com', $user->email);
    }

    /** @test */
    public function it_can_search_for_a_term_without_passing_attributes_using_searchable_method()
    {
        UserWithSearchableMethod::create([
            'name'  => 'Richard Roe',
            'email' => 'richard@doe.com'
        ]);

        $user = UserWithSearchableMethod::search('richard')->first();

        $this->assertEquals('Richard Roe', $user->name);
        $this->assertEquals('richard@doe.com', $user->email);
    }

    /** @test */
    public function it_can_search_in_multiple_attributes_without_passing_a_term()
    {
        User::create([
            'name'  => 'Janie Roe',
            'email' => 'janie@doe.com',
        ]);

        // simulate GET request with query parameter "?q=janie"
        request()->query->add(['q' => 'janie']);

        $user = User::search(['name', 'email', 'phone'])->first();

        $this->assertEquals('Janie Roe', $user->name);
        $this->assertEquals('janie@doe.com', $user->email);

        request()->query->remove('q');

        // update request query key
        config(['searchable.key' => 'keyword']);

        // simulate GET request with query parameter "?keyword=janie"
        request()->query->add(['keyword' => 'janie']);

        $user = User::search(['name', 'email', 'phone'])->first();

        $this->assertEquals('Janie Roe', $user->name);
        $this->assertEquals('janie@doe.com', $user->email);
    }

    /**
     * Create multiple users
     *
     * @return array
     */
    private function createMultipleUsers()
    {
        $users = [];

        foreach (range(1, 5) as $i) {
            $user = User::create([
                'name'  => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'phone' => $this->faker->phoneNumber,
            ]);

            array_push($users, $user);
        }

        return $users;
    }
}
