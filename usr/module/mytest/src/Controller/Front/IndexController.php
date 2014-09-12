<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Mytest\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
// use Pi\Paginator\Paginator;
use Module\Mytest\Form\ContactusForm;
use Module\Mytest\Form\ContactusFilter;
class IndexController extends ActionController
{
    protected $contactusColumns = array(
        'id', 'username', 'gender', 'telephone', 'email', 'company', 'note'
    );
    /**
     * A test to say "Hello World!"
     */
    public function indexAction(){
        // Assign param
        $word="Hello World";
        $this->view()->assign('word', $word);

        // Specify template,
        // otherwise template will be set up as {controller}-{action}
        $this->view()->setTemplate('mytest-index');
    }
    /**
     * Contact us 
     */
    public function contactusAction(){
        $messages = array();
        $form = new ContactusForm('contactus');
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            $form->setInputFilter(new ContactusFilter);
            if($form->isValid()) {
                $values = $form->getData();
                foreach (array_keys($values) as $key) {
                    if (!in_array($key, $this->contactusColumns)) {
                        unset($values[$key]);
                    }
                }
                unset($values['id']);
                $values['create_at'] = time();
                $row = Pi::model('mytest/contactus')->createRow($values);
                $row->save();
                if($row->id) {
                    $messages = _a('Customer data saved successfully.');
                    $this->redirect()->toRoute('', array('action' => 'index'));
                    return;
                } else {
                    $messages = _a('Customer data not saved.');
                }
            }
            else {
                $messages = _a('Invalid data, please check and re-submit.');
            }

            $messages[] = _a('Form submitted successfully.');
        }


        $this->view()->assign(array(
            'form'      => $form,
            'messages'  => $messages,
        ));
        $this->view()->setTemplate('mytest-form');
    }
}
