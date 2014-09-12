<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Mytest\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Module\Mytest\Form\ContactusForm;
use Module\Mytest\Form\ContactusFilter;

/**
 * Feature list:
 *
 *  1. List of routes
 *  2. Edit a route
 *  5. Delete a route
 */
class IndexController extends ActionController
{
    protected $contactusColumns = array(
        'id', 'username', 'gender', 'telephone', 'email', 'company', 'note', 'create_at'
    );
    /**
     * List of routes
     */
    public function indexAction()
    {
        $module = $this->getModule();
        $model  = $this->getModel('contactus');
        $select = $model->select()->order(array('id DESC'));
        $rowset = $model->selectWith($select);
        $userlist = array();
        foreach ($rowset as $row) {
            $userlist[] = array(
                'id'        => $row['id'],
                'username'  => $row['username'],
                'gender'    => $row['gender'],
                'telephone' => $row['email'],
                'company'   => $row['company'],
                'note'      => $row['note'],
                'create_at' => date('Y-m-d H:i:s', $row['create_at'])
            );
        }
        // var_dump($userlist);exit;

        $this->view()->assign('userlist', $userlist);
        $this->view()->setTemplate('user-list');
    }
}
