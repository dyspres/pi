<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

namespace Module\Media\Api;

use Closure;
use Pi;
use Pi\Application\AbstractApi;

class Doc extends AbstractApi
{
    /**
     * Module name
     * @var string
     */
    protected $module = 'media';

    /**
     * Get model
     *
     * @param string $name
     *
     * @return Pi\Application\Model\Model
     */
    protected function model($name = 'doc')
    {
        $model = Pi::Model($name, $this->module);

        return $model;
    }

    /**
     * Add an application
     *
     * @param array $data
     *
     * @return int
     */
    public function addApplication(array $data)
    {
        $model  =$this->model('application');
        $row = $model->find($data['appkey'], 'appkey');
        if (!$row) {
            $row = $model->createRow($data);
        } else {
            $row->assign($data);
        }
        $row->save();

        return (int) $row->id;
    }

    /**
     * Add a doc
     *
     * @param array $data
     *
     * @return int
     */
    public function add(array $data)
    {
        $row = $this->model()->createRow($data);
        $row->save();

        return (int) $row->id;
    }

    /**
     * Upload a doc and save meta
     *
     * @TODO not completed
     * 
     * @param array $params
     * @param string $method
     *
     * @return int doc id
     */
    public function upload(array $params, $method = 'POST')
    {
        $options = Pi::service('media')->getOption('local');
        $rootUri = $options['root_uri'];
        $rootPath = $options['root_path'];
        $path = $options['locator']['path'];
        if ($path instanceof Closure) {
            $relativePath = $path();
        } else {
            $relativePath = $path;
        }
        $destination = $rootPath . '/' . $relativePath;
        $rename = $options['locator']['file'];

        $success = false;
        switch ($method) {
            case 'POST':
                $uploader = new Upload(array(
                    'destination'   => $destination,
                    'rename'        => $rename,
                ));
                if ($uploader->isValid()) {
                    $uploader->receive();
                    $filename = $uploader->getUploaded();
                    $success = true;
                }
                break;
            case 'PUT':
                $putdata = fopen('php://input', 'r');
                $filename = $rename($params['name']);
                $target = $destination  . '/' . $filename;
                $fp = fopen($target, 'w');
                while ($data = fread($putdata, 1024)) {
                    fwrite($fp, $data);
                }
                fclose($fp);
                fclose($putdata);

                $success = true;
                break;
            default:
                break;
        }
        if ($success) {
            $params['url'] = $rootUri . '/' . $relativePath . '/' . $filename;
            $params['path'] = $rootPath . '/' . $relativePath . '/' . $filename;

            $row = $this->model()->createRow($params);
            $row->save();
            $result = $row['id'];
        } else {
            $result = 0;
        }

        return $result;
    }
    
    /**
     * Update doc
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data)
    {
        $row = $this->model()->find($id);
        if ($row) {
            $row->assign($data);
            $row->save();

            return true;
        }

        return false;
    }
    
    /**
     * Active media
     * 
     * @param int $id
     * @param bool $flag
     *
     * @return bool
     */
    public function activate($id, $flag = true)
    {
        $result = $this->upate($id, array('active' => $flag ? 1 : 0));

        return $result;
    }

    /**
     * Get media attributes
     * 
     * @param int|int[] $id
     * @param string|string[] $attribute
     * @return mixed
     */
    public function get($id, $attribute = array())
    {
        $model  = $this->model();
        $select = $model->select()->where(array('id' => $id));
        if ($attribute) {
            $select->columns((array) $attribute);
        }
        $rowset = $model->selectWith($select);
        $result = array();
        foreach ($rowset as $row) {
            if ($attribute && is_salar($attribute)) {
                $result[$row['id']] = $row[$attribute];
            } else {
                $result[$row['id']] = $row->toArray();
            }
        }
        if (is_scalar($id)) {
            if (isset($result[$id])) {
                $result = $result[$id];
            } else {
                $result = array();
            }
        }

        return $result;
    }
    
    /**
     * Get attributes of medias
     * 
     * @param int[] $ids
     * @param string|string[] $attribute
     * @return array
     */
    public function mget($ids, $attribute = array())
    {
        $result = $this->get($ids, $attribute);

        return $result;
    }
    
    /**
     * Get doc statistics
     * 
     * @param int $id
     * @return array
     */
    public function getStats($id)
    {
        $model  = $this->model('stats');
        $rowset = $model->select(array('id' => $id));
        $result = array();
        foreach ($rowset as $row) {
            $result[$row['id']] = $row->toArray();
        }
        if (is_scalar($id)) {
            if (isset($result[$id])) {
                $result = $result[$id];
            } else {
                $result = array();
            }
        }

        return $result;
    }
    
    /**
     * Get statistics of docs
     * 
     * @param int[] $ids
     * @return array
     */
    public function getStatsList(array $ids)
    {
        $result = $this->getStats($ids);

        return $result;
    }
    
    /**
     * Get file IDs by given condition
     *
     * @param array  $condition
     * @param int    $limit
     * @param int    $offset
     * @param string|array $order
     *
     * @return int[]
     */
    public function getIds(
        array $condition,
        $limit  = 0,
        $offset = 0,
        $order  = ''
    ) {
        $result = $this->getList(
            $condition,
            $limit,
            $offset,
            $order,
            array('id')
        );
        array_walk($result, function (&$data) {
            return (int) $data['id'];
        });

        return $result;
    }
    
    /**
     * Get list by condition
     *
     * @param array  $condition
     * @param int    $limit
     * @param int    $offset
     * @param string|array $order
     * @param array $attr
     *
     * @return array
     */
    public function getList(
        array $condition,
        $limit  = 0,
        $offset = 0,
        $order  = '',
        array $attr = array()
    ) {
        $model  = $this->model();
        $select = $model->select()->where($condition);
        if ($limit) {
            $select->limit($limit);
        }
        if ($offset) {
            $select->offset($offset);
        }
        if ($order) {
            $select->order($order);
        }
        if ($attr) {
            $select->columns($attr);
        }
        $rowset = $model->selectWith($select);
        $result = array();
        foreach ($rowset as $row) {
            $result[] = $row->toArray();
        }

        return $result;
    }
    
    /**
     * Get media count by condition
     * 
     * @param array $condition
     * @return int
     */
    public function getCount(array $condition = array())
    {
        $result = $this->model()->count($condition);
        
        return $result;
    }
    
    /**
     * Get media url
     * 
     * @param int|int[] $id
     * @return string|array
     */
    public function getUrl($id)
    {
        $url = $this->get($id, 'url');

        return $url;
    }

    /**
     * Download a media file to local file
     *
     * @param int|int[] $id Doc id
     * @param string $file Absolute path to save; or output to browser directly
     *
     * @return bool
     */
    public function download($id, $file = '')
    {
        $url = Pi::service('url')->assemble('default', array(
            'module'     => $this->module,
            'controller' => 'download',
            'action'     => 'index',
            'id'         => implode(',', (array) $id),
        ));

        header(sprintf('location: %s', $url));
    }
    
    /**
     * Delete docs
     * 
     * @param int|int[] $ids
     * @return bool
     */
    public function delete($ids)
    {
        $result = $this->model()->update(
            array('time_deleted' => time(), 'active' => 0),
            array('id' => $ids)
        );

        return $result;
    }
}