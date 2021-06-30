<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserControllerTest extends TestCase
{

    private $secret = '12345';

    
    /**
     * Try to check is user login.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testCheckUser()
    {     
        $token = $this->getTokenForUser($this->user());
        $response = $this->json('GET', 'api/checkuser', [], ['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(200)
        ->assertJsonStructure([
            'user',
        ]);
    }

    /**
     * Try to check unautorized user.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testCheckUserWithBadToken()
    {     
        $response = $this->json('GET', 'api/checkuser', [], ['Authorization' =>'Bearer '.'bad token number', 'Secret'=>$this->secret]);
        $response->assertStatus(401)
        ->assertJsonStructure([
            'message',
        ]);
    }
  
    /**
     * Try to check user with bad secret key.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testCheckUserWithBadSecret()
    {     
        $token = $this->getTokenForUser($this->user());
        $response = $this->json('GET', 'api/checkuser', [], ['Authorization' =>'Bearer '.$token, 'Secret'=>'bad secret key']);
        // print_r($response->getContent());
        $response->assertStatus(401)
        ->assertJsonStructure([
            'message',
        ]);
    }

    /**
     * Try to get user profile.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testProfile()
    {
        $token = $this->getTokenForUser($this->user());
        $response = $this->json('GET', 'api/profile', [], ['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(200)
        ->assertJsonStructure([
            'user',
        ]);
    }


    /**
     * Try to add new user after login.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testAddUser()
    {
        $token = $this->getTokenForUser($this->user());
        $response = $this->json('POST', 'api/adduser', ['name'=>'testuser01', 'email'=>'testuser01@example.pl', 'password'=>'testpassword', 'role'=>'user'], ['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'user',
        ]);
    }


    /**
     * Try to register new user.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testRegister()
    {
        $token = $this->getTokenForUser($this->user());
        $response = $this->json('POST', 'api/register', ['name'=>'testuser01', 'email'=>'testuser01@example.pl', 'password'=>'testpassword', 'role'=>'user'], ['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'user',
        ]);
    }


    /**
     * Try to update user account.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testUpdateUser()
    {
        $token = $this->getTokenForUser($this->user('a@a.pl'));
        $response = $this->json('PUT', 'api/updateprofile', ['name'=>'Jack Smith', 'email'=>'a@a.pl', 'password'=>'aaa', 'role'=>'old'], ['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
        ]);
    }


    /**
     * Try to update user account.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testBadData()
    {
        $token = $this->getTokenForUser($this->user('a@a.pl'));
        $response = $this->json('PUT', 'api/updateprofile', ['name2'=>'Jack Smith', 'email2'=>'a@a.pl', 'password2'=>'aaa', 'rol2e'=>'old'], ['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
        ]);
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
        $token = $this->getTokenForUser($this->user());
        $response = $this->json('POST', 'api/checkuser', [], ['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(405)
        ->assertJsonStructure([
            'message',
        ]);

    }

}
