<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Pi\Authentication\Adapter\DbTable;

/**
 * Pi authentication db table credential treatment adapter
 *
 * @author Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
 * @see \Zend\Authentication\DbTable\AbstractAdapter
 */
class CredentialTreatmentAdapter extends AbstractAdapter
{
    /**
     * {@inheritDoc}
     */
    protected function authenticateValidateResult($resultIdentity)
    {
        throw new \Exception('Not implemented yet.');
    }
}
