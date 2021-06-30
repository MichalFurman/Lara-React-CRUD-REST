<?php

namespace Tests\Unit;

use Tests\TestCase;

class FileControllerTest extends TestCase
{


    private $secret = '12345';

  /**
     * A basic unit test example.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
     public function testIndex()
    {
        $token = $this->getTokenForUser($this->user());
        $response = $this->json('GET', 'api/files', [], ['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(200)
        ->assertJsonStructure([
          'message',
          'files' => [0 => [
                'id',
                'user_id',
                'name',
                'file',
                'path',
                'user_name',
                ],
            ],
        ]);
    }


    /**
     * Try to delete file with bad ID.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testBadDelete()
    {
        $token = $this->getTokenForUser($this->user());
        $response = $this->json('DELETE', 'api/files/0', [], ['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(400)
        ->assertJsonStructure([
            'message',
        ]);
    }


    /**
     * Try to edit file with bad ID.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testEditMissingData()
    {
        $token = $this->getTokenForUser($this->user());
        $response = $this->json('PUT', 'api/files/0', [], ['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
        ]);
    }


    /**
     * Try to edit file with bad ID.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testEditBadId()
    {
        $token = $this->getTokenForUser($this->user());
        $response = $this->json('PUT', 'api/files/0', ['name'=>'test'], ['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(400);
    }


    /**
     * Try to edit file with bad data.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testEditBadData()
    {
        $token = $this->getTokenForUser($this->user());
        $response = $this->json('PUT', 'api/files/0', ['name2'=>'test2'], ['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
        ]);
    }


    /**
     * Try to edit file with bad data length.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testEditBadDataLength()
    {
        $token = $this->getTokenForUser($this->user());
  		$response = $this->json('PUT', 'api/files/0', ['name2'=>'test212121213132131313213132133132321313321321321321154648746481354/76545143489776416/7635184y345'], 
		['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
        ]);
    }


	/**
     * Try to edit file with bad ID.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testDeleteId()
    {
        $token = $this->getTokenForUser($this->user());
        $response = $this->json('DELETE', 'api/files/35', [], ['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
        ]);
    }


    /**
     * Try to delete file with bad ID.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testDeleteBadId()
    {
        $token = $this->getTokenForUser($this->user());
        $response = $this->json('DELETE', 'api/files/0', [], ['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(400)
        ->assertJsonStructure([
            'message',
        ]);
    }


    /**
     * Try to delete file with bad ID.
     *
     * @return void
     */
    /**
     * @runInSeparateProcess
     */
    public function testBadMethod()
    {
        $token = $this->getTokenForUser($this->user());
        $response = $this->json('POST', 'api/files/0', [], ['Authorization' =>'Bearer '.$token, 'Secret'=>$this->secret]);
        $response->assertStatus(405)
        ->assertJsonStructure([
            'message',
        ]);

    }

}
