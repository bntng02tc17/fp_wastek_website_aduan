<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model\Query;

class AduanController extends Controller
{

    public function initialize(){

        $this->view->auth = $this->session->get('auth');
    }

    public function indexAction()
    {
        $auth = $this->session->get('auth');
        if($auth['role'] !== 'admin')
        {
            $this->flash->error(
                'Anda tidak memiliki akses untuk melihat semua aduan'
            );

            return $this->dispatcher->forward(
                [
                    'controller' => 'aduan',
                    'action'     => 'myindex',
                ]
            );
        }

        $id = $auth['id'];

        $query = $this->modelsManager->createQuery('SELECT u.*, a.* FROM Aduans a, Users u  WHERE a.user_id = u.id  ORDER BY a.created_on ASC ');
        $rows  = $query->execute(
            // [
            //     'pid' => $id,
            // ]
        );
        $this->view->aduans = $rows;

        $this->view->auth = $this->session->get('auth');
    }
    public function myindexAction()
    {
        $auth = $this->session->get('auth');
        $id = $auth['id'];

        $query = $this->modelsManager->createQuery('SELECT u.*, a.* FROM Aduans a, Users u  WHERE a.user_id = u.id AND u.id = :pid: ORDER BY a.created_on ASC ');
        $rows  = $query->execute(
            [
                'pid' => $id,
            ]
        );
        $this->view->aduans = $rows;

        $this->view->auth = $this->session->get('auth');

        //$this->view->disable();
    }

    public function createAction()
    {
        $auth = $this->session->get('auth');

        if($auth['role'] == null)
        {
            $this->flash->error(
                'Anda tidak memiliki akses untuk membuat aduan'
            );

            return $this->dispatcher->forward(
                [
                    'controller' => 'aduan',
                    'action'     => 'myindex',
                ]
            );
        }
    }

    public function saveAction()
    {
        $aduan = new Aduans();
        $auth = $this->session->get('auth');

        $aduan->assign(
            $this->request->getPost(),
            [
                'judul',
                'isi',
            ]
        );
        $aduan->user_id = $auth['id'];
        $success = $aduan->save();
        if ($this->request->hasFiles()) {
            $baseLocation = BASE_PATH.'/public/image/';
            $uploadedFile = $this->request->getUploadedFiles()[0];
            $aduan->filepath = 'aduan_'.$aduan->id.'.'.$uploadedFile->getExtension();
            $uploadedFile->moveTo($baseLocation . $aduan->filepath);
            $success = $aduan->save();
        }

        if ($success) {
            $this->flash->success("Aduan berhasil dibuat");

            return $this->dispatcher->forward(
                [
                    'controller' => 'aduan',
                    'action'     => 'myindex',
                ]
            );
        } else {
            $message = "Mohon maaf, ada permasalahan berikut :  "
                    . implode(', ', $aduan->getMessages());
            $this->flash->error($message);

            return $this->dispatcher->forward(
                [
                    'controller' => 'aduan',
                    'action'     => 'create',
                ]
            );
        }

    }
    public function editAction($id)
    {
        $id = $id;
        $aduan = Aduans::findFirst(
            [
                'conditions' => 'id = :id:',
                'bind'       => [
                    'id' => $id,
                ],
            ]
        );
        $this->view->aduan = $aduan;

    }
    public function updateAction()
    {
        $judul = $this->request->getPost('judul');
        $isi = $this->request->getPost('isi');
        $id = $this->request->getPost('id');

        $aduan = Aduans::findFirst(
            [
                'conditions' => 'id = :id:',
                'bind'       => [
                    'id' => $id,
                ],
            ]
        );
        $aduan->isi = $isi;
        $aduan->judul = $judul;

        if ($this->request->hasFiles()) {
            $baseLocation = BASE_PATH.'/public/image/';
            $uploadedFile = $this->request->getUploadedFiles()[0];
            $aduan->filepath = 'aduan_'.$aduan->id.'.'.$uploadedFile->getExtension();
            $uploadedFile->moveTo($baseLocation . $aduan->filepath);
        }

        $success = $aduan->save();

        if ($success) {
            $this->flash->success("Aduan berhasil diedit");

            return $this->dispatcher->forward(
                [
                    'controller' => 'aduan',
                    'action'     => 'index',
                ]
            );

        } else {
            $message = "Mohon maaf, ada permasalahan berikut :  "
                    . implode(', ', $aduan->getMessages());
            $this->flash->error($message);

            return $this->dispatcher->forward(
                [
                    'controller' => 'aduan',
                    'action'     => 'edit',
                    'params' => [$id,],
                ]
            );
        }

    }
    public function deleteAction($id)
    {
        $id = $id;
        $aduan = Aduans::findFirst(
            [
                'conditions' => 'id = :id:',
                'bind'       => [
                    'id' => $id,
                ],
            ]
        );
        $success = $aduan->delete();

        if ($success) {
            $this->flash->success("Aduan berhasil dihapus");

            return $this->dispatcher->forward(
                [
                    'controller' => 'aduan',
                    'action'     => 'index',
                ]
            );

        } else {
            $message = "Mohon maaf, ada permasalahan berikut :  "
                    . implode(', ', $aduan->getMessages());
            $this->flash->error($message);

            return $this->dispatcher->forward(
                [
                    'controller' => 'aduan',
                    'action'     => 'index',
                ]
            );
        }
    }

    
    public function viewAction($id)
    {
        $id = $id;
        $aduan = Aduans::findFirst(
            [
                'conditions' => 'id = :id:',
                'bind'       => [
                    'id' => $id,
                ],
            ]
        );

        $this->view->aduan = $aduan;

    }
}
