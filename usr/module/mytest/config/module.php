<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link         http://code.pialog.org for the Pi Engine source repository
 * @copyright    Copyright (c) Pi Engine http://pialog.org
 * @license      http://pialog.org/license.txt BSD 3-Clause License
 */

/**
 * Module config and meta
 * 
 * @author yuandi@social-touch.com
 */
return array(
    // Module meta
    'meta'         => array(
        'title'         => _a('Mytest'),
        'description'   => _a('Tests for practce.'),
        'version'       => '0.1',
        'license'       => 'New BSD',
        'logo'          => 'image/logo.png',
        'readme'        => 'README.md',
        'icon'          => 'fa-edit',
        'clonable'      => false,
    ),
    // Author information
    'author'        => array(
        'Name'          => 'Di Yuan',
        'Email'         => 'yuandi.dyspres@gmail.com',
        'Website'       => 'https://github.com/dyspres',
        'Credits'       => 'Pi Engine Team.'
    ),
    // Module dependency: list of module directory names, optional
    'dependency'    => array(
    ),
    // Maintenance resources
    'resource'      => array(
        'database'      => array(
            'sqlfile'      => 'sql/mysql.sql',
        ),
        // Database meta
        'navigation'    => 'navigation.php',
        'block'         => 'block.php',
        'config'        => 'config.php',
        'route'         => 'route.php',
        'page'          => 'page.php',
    ),
);
