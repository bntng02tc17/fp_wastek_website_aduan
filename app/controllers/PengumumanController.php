<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;


class PengumumanController extends Controller
{


    public function initialize(){

        $this->view->auth = $this->session->get('auth');
    }

    public function indexAction()
    {
        $pengumumans = Pengumumans::find();

        $this->view->pengumumans = $pengumumans;
        $this->view->auth = $this->session->get('auth');
        // var_dump($auth);
        // $this->view->disable();
    }

    public function createAction()
    {
        $auth = $this->session->get('auth');

        if($auth['role'] !== 'admin')
        {
            $this->flash->error(
                'Anda tidak memiliki akses untuk membuat pengumuman'
            );

            return $this->dispatcher->forward(
                [
                    'controller' => 'pengumuman',
                    'action'     => 'index',
                ]
            );
        }
    }

    public function saveAction()
    {
        $pengumuman = new Pengumumans();
        $auth = $this->session->get('auth');

        $pengumuman->assign(
            $this->request->getPost(),
            [
                'judul',
                'isi',
            ]
        );
        $pengumuman->admin_id = $auth['id'];
        $success = $pengumuman->save();
        if ($this->request->hasFiles()) {
            $baseLocation = BASE_PATH.'/public/image/';
            $uploadedFile = $this->request->getUploadedFiles()[0];
            $pengumuman->filepath = 'pengumuman_'.$pengumuman->id.'.'.$uploadedFile->getExtension();
            $uploadedFile->moveTo($baseLocation . $pengumuman->filepath);
            $success = $pengumuman->save();
        }

        if ($success) {
            $this->flash->success("Pengumuman berhasil dibuat");

            return $this->dispatcher->forward(
                [
                    'controller' => 'pengumuman',
                    'action'     => 'index',
                ]
            );
        } else {
            $message = "Mohon maaf, ada permasalahan berikut :  "
                    . implode(', ', $pengumuman->getMessages());
            $this->flash->error($message);
            
            // var_dump($message);
            // die();

            return $this->dispatcher->forward(
                [
                    'controller' => 'pengumuman',
                    'action'     => 'create',
                ]
            );
        }

    }
    public function editAction($id)
    {
        $id = $id;
        $pengumuman = Pengumumans::findFirst(
            [
                'conditions' => 'id = :id:',
                'bind'       => [
                    'id' => $id,
                ],
            ]
        );
        $this->view->pengumuman = $pengumuman;

    }


    public function detailAction($id)
    {
        $id = $id;
        $pengumuman = Pengumumans::findFirst(
            [
                'conditions' => 'id = :id:',
                'bind'       => [
                    'id' => $id,
                ],
            ]
        );
        $this->view->pengumuman = $pengumuman;

    }




    public function updateAction()
    {
        $judul = $this->request->getPost('judul');
        $isi = $this->request->getPost('isi');
        $id = $this->request->getPost('id');

        $pengumuman = Pengumumans::findFirst(
            [
                'conditions' => 'id = :id:',
                'bind'       => [
                    'id' => $id,
                ],
            ]
        );
        $pengumuman->isi = $isi;
        $pengumuman->judul = $judul;


        if ($this->request->hasFiles()) {
            $baseLocation = BASE_PATH.'/public/image/';
            $uploadedFile = $this->request->getUploadedFiles()[0];
            $pengumuman->filepath = 'pengumuman_'.$pengumuman->id.'.'.$uploadedFile->getExtension();
            $uploadedFile->moveTo($baseLocation . $pengumuman->filepath);
        }

        $success = $pengumuman->save();

        if ($success) {
            $this->flash->success("Pengumuman berhasil diedit");

            return $this->dispatcher->forward(
                [
                    'controller' => 'pengumuman',
                    'action'     => 'index',
                ]
            );

        } else {
            $message = "Mohon maaf, ada permasalahan berikut :  "
                    . implode(', ', $pengumuman->getMessages());
            $this->flash->error($message);

            return $this->dispatcher->forward(
                [
                    'controller' => 'pengumuman',
                    'action'     => 'edit',
                    'params' => [$id,],
                ]
            );
        }

    }
    
    
    
    public function deleteAction($id)
    {
        $id = $id;
        $pengumuman = Pengumumans::findFirst(
            [
                'conditions' => 'id = :id:',
                'bind'       => [
                    'id' => $id,
                ],
            ]
        );
        $success = $pengumuman->delete();

        if ($success) {
            $this->flash->success("Pengumuman berhasil dihapus");

            return $this->dispatcher->forward(
                [
                    'controller' => 'pengumuman',
                    'action'     => 'index',
                ]
            );

        } else {
            $message = "Mohon maaf, ada permasalahan berikut :  "
                    . implode(', ', $pengumuman->getMessages());
            $this->flash->error($message);

            return $this->dispatcher->forward(
                [
                    'controller' => 'pengumuman',
                    'action'     => 'index',
                ]
            );
        }

    }
}
