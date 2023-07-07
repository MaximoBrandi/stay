<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_basic_example(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login');
            $browser->type('email', "accountant-1@gmail.com")
                    ->type('password', '12341234');
            $browser->press('@login');
            $browser->visit('/database');
            $browser->press('Course 1');
            $browser->pause(1000);

            $browser->screenshot('pistachomolido');
        });
    }
}
