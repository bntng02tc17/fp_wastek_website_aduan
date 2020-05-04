<?php

use Phalcon\Mvc\Model;

class Pengumumans extends Model
{
    public $id;
    public $admin_id;
    public $judul;
    public $isi;
    public $created_on;

    public function initialize()
    {
        $this->setSource('Pengumumans');

        $this->belongsTo(
            'admin_id',
            Users::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'admin',
            ]
        );
    }


}

?>