<?php

namespace Tests\Unit;

use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    /**
     * Try to login with good login and password.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testLogin()
    {
        $response = $this->json('POST', 'api/login', ['email'=>'a@a.pl','password'=>'aaa' ]);
        $response->assertStatus(200)
        ->assertJsonStructure([
            'token',
            'secret',
        ]);
    }

    
    /**
     * Try to login with bad login and password.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */

    public function testBadLogin()
    {
        $response = $this->json('POST', 'api/login', ['email'=>'badlogin','password'=>'badpassword']);
        $response->assertStatus(401)
        ->assertJson(['message'=>'invalid_credentials']);
    }


    /**
     * Try to execute bad request method.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testBadMethod()
    {
        $response = $this->json('PUT', 'api/login', ['email'=>'a@a.pl','password'=>'aaa']);
        $response->assertStatus(405)
        ->assertJsonStructure([
            'message',
        ]);
    }

    /**
     * Try to send bad data to login.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testBadData()
    {
        $response = $this->json('POST', 'api/login', ['email2'=>'a@a.pl','password2'=>'aaa']);
        $response->assertStatus(401)
        ->assertJsonStructure([
           'message',
        ]);

    }

}
