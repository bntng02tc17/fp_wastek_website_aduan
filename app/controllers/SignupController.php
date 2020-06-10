<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

//use Phalcon\Flash\Direct;

class SignupController extends Controller
{
    public function indexAction()
    {

    }

    public function registerAction()
    {
        $no_ktp = $this->request->getPost('no_ktp');
        $password = $this->request->getPost('password');

        // echo $no_ktp;
        // echo $password;

        $user = Users::findFirst(
            [
                'conditions' => 'no_ktp = :no_ktp:',
                'bind'       => [
                    'no_ktp' => $no_ktp,
                ],
            ]
        );

        if($user && null !== $user->no_ktp)
        {
            $this->flash->error(
                'Nomor KTP sudah pernah digunakan. Silakan gunakan nomor KTP yang lain.'
            );
            return $this->dispatcher->forward(
                [
                    'controller' => 'signup',
                    'action'     => 'index',
                ]
            );

        }
        else
        {
            $user = new Users();

            $user->assign(
                $this->request->getPost(),
                [
                    'nama',
                    'no_ktp',
                    'password'
                ]
                );
            $user->role = 'admin';

            $success = $user->save();

            // passing the result to the view
            $this->view->success = $success;

            if ($success) {
                $this->flash->success("Selamat Anda telah berhasil mendaftar");

                return $this->dispatcher->forward(
                    [
                        'controller' => 'index',
                        'action'     => 'index',
                    ]
                );
            } else {
                $message = "Mohon maaf, ada permasalahan berikut :  "
                        . implode(', ', $user->getMessages());
                $this->flash->error($message);

                return $this->dispatcher->forward(
                    [
                        'controller' => 'signup',
                        'action'     => 'index',
                    ]
                );
            }
            
        }

        //$this->view->disable();

    }
}
