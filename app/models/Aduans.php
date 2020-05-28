<?php

use Phalcon\Mvc\Model;

class Aduans extends Model
{
    public $id;
    public $user_id;
    public $judul;
    public $isi;
    public $created_on;
    public $filepath;

    public function initialize()
    {
        $this->setSource('Aduans');

        $this->belongsTo(
            'user_id',
            Users::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'user',
            ]
        );
    }


}

?>