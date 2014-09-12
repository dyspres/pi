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
use Zend\InputFilter\InputFilter;
use Zend\Validator;

class ContactusFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'          => 'id',
            'required'      => false,
        ));

        $this->add(array(
            'name'          => 'username',
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
        ));

        $this->add(array(
            'name'          => 'gender',
        ));

        $this->add(array(
            'name'          => 'telephone',
        ));

        $this->add(array(
            'name'          => 'email',
        ));

        $this->add(array(
            'name'          => 'company',
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
        ));

        $this->add(array(
            'name'          => 'note',
        ));
    }
}