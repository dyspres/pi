<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Mytest\Form;

use Pi;
use Pi\Form\Form as BaseForm;

class contactusForm extends BaseForm
{
    public function getInputFilter(){
        if (!$this->filter){
            $this->filter = new ContactusFilter;
        }
        return $this->filter;
    }

    public function init(){

        $this->add(array(
            'name'          => 'id',
            'attributes'    => array(
                'type'  => 'hidden',
                'value' => 0,
            )
        ));

        $this->add(array(
            'name'          => 'username',
            'options'       => array(
                'label' => __('Username'),
            ),
            'type'  => 'text',
            'required'  =>  true,
            'attributes' => array(
                'data-width' => '3',
            ),
        ));

        $this->add(array(
            'name'          => 'gender',
            'options'       => array(
                'label' => __('Gender'),
                'value_options' => array(
                     '0' => 'Female',
                     '1' => 'Male',
                 ),
                'label_attributes' => array(
                    'class' => 'radio-inline'
                ),
            ),
            'type'  => 'radio',
        ));

        $this->add(array(
            'name'          => 'telephone',
            'options'       => array(
                'label' => __('Tel'),
            ),
            'type'  => 'text',
            'required' => true,
            'attributes' => array(
                'data-width' => '3',
            ),
        ));    

        $this->add(array(
            'name'          => 'email',
            'options'       => array(
                'label' => __('Email'),
            ),
            'type'  => 'text',
            'attributes' => array(
                'data-width' => '3',
            ),
            'required' => true,
        ));

        $this->add(array(
            'name'          => 'company',
            'options'       => array(
                'label' => __('Company'),
            ),
            'type'  => 'text',
            'attributes' => array(
                'data-width' => '3',
            ),
            'required' => true,
        ));

        $this->add(array(
            'name'          => 'note',
            'options'       => array(
                'label' => __('Note'),
            ),
            'type'  => 'textarea',
            'attributes' => array(
                'data-width' => '3',
            ),
            'required' => true,
        ));

        $this->add(array(
            'name'          => 'submit',
            'type'          => 'submit',
            'attributes'    => array(
                'value' => __('Submit'),
                'class' => 'btn btn-primary'
            )
        ));
    }
}
