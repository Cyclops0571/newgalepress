<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/test')->see('zzzzzzzzz');
        $this->visit(__('route.login'))->see('currentLanguage');
        $this->post(__('route.login'),   ['Username' => 'srdsaygili@gmail.com','Password' => 'serd12'])->see('success');
    }
}
