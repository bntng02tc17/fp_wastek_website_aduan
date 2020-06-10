<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use Phalcon\Http\Request;

//use Phalcon\Flash\Direct;

class LoginController extends Controller
{
    public function indexAction()
    {

    }

    public function signinAction()
    {
        $no_ktp = $this->request->getPost('no_ktp');
        $password = $this->request->getPost('password');

        // echo $no_ktp;
        // echo $password;

        $user = Users::findFirst(
            [
                'conditions' => 'no_ktp = :no_ktp: AND password = :password:',
                'bind'       => [
                    'no_ktp' => $no_ktp,
                    'password' => $password
                ],
            ]
        );

        if($user)
        {
            if(null !== $user->no_ktp)
            {
                $this->session->set(
                    'auth',
                    [
                        'id'   => $user->id,
                        'nama' => $user->nama,
                        'role' => $user->role,
                        'no_ktp' => $user->no_ktp
                    ]
                );
    
                // $this->flash->success(
                //     'Welcome ' . $user->nama
                // );
    
                // return $this->dispatcher->forward(
                //     [
                //         'controller' => 'aduan',
                //         'action'     => 'myindex',
                //     ]
                // );
                if($user->role=="admin")
                {
                    $this->response->redirect('aduan/index');
                }
                else
                {
                    $this->response->redirect('aduan/myindex');
                }
    
            }

        }
        else{
            $this->flash->error(
                'Nomor KTP / PASSWORD salah.'
            );

            return $this->dispatcher->forward(
                [
                    'controller' => 'login',
                    'action'     => 'index',
                ]
            );
        }
    }

    public function signoutAction()
    {
        $this->session->destroy();
        $this->flash->success(
            'Anda berhasil logout'

        );
        return $this->dispatcher->forward(
            [
                'controller' => 'index',
                'action'     => 'index',
            ]
        );
        
    }
}

?>