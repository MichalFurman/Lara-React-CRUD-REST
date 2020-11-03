<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\User;


class FileUpload extends Model
{
    protected $fillable =['name', 'path'];

    public function allFiles(){
        $user = new User();
        return DB::table($this->getTable())
                    ->leftJoin($user->getTable(), $this->getTable().'.user_id','=', $user->getTable().'.id')
                    ->select(array($this->getTable().'.*', $user->getTable().'.name as user_name'));
    }
}
