<?php

use Phalcon\Mvc\Model;

class Users extends Model
{
    public $id;
    public $nama;
    public $no_ktp;
    public $password;
    public $role;

    public function initialize()
    {
        $this->setSource('Users');

        $this->hasMany(
            'id',
            Pengumumans::class,
            'admin_id',
            [
                'reusable' => true,
                'alias'    => 'pengumumans'
            ]
        );

        $this->hasMany(
            'id',
            Aduans::class,
            'user_id',
            [
                'reusable' => true,
                'alias'    => 'aduans'
            ]
        );
    }

    


}

?>