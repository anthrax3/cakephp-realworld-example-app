<?php
/**
 * Copyright 2017, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2017, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace App\Service\Action\Article;

use Cake\Network\Exception\ForbiddenException;

class ArticleDeleteAction extends ArticleViewAction
{

    public $isPublic = false;

    /**
     * Apply validation process.
     *
     * @return bool
     */
    public function validates()
    {
        $record = $this->_getEntity($this->_id);
        if ($record['author_id'] != $this->Auth->user('id')) {
            throw new ForbiddenException();
        }

        return true;
    }

    /**
     * Execute action.
     *
     * @return mixed
     */
    public function execute()
    {
        $record = $this->_getEntity($this->_id);
        if ($record) {
            $result = $this->getTable()->delete($record);
        }

        return !empty($result);
    }

    /**
     * Returns single entity by id.
     *
     * @param mixed $primaryKey Primary key.
     * @return \Cake\Collection\Collection
     */
    protected function _getEntity($primaryKey)
    {
        return $this->getTable()
          ->find()
          ->where(['Articles.slug' => $primaryKey])
          ->firstOrFail();
    }
}
