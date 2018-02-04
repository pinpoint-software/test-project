<?php
namespace Application\AtlasOrm\DataSource\Text;

use Application\AtlasOrm\DataSource\User\UserMapper;
use Atlas\Orm\Mapper\AbstractMapper;

/**
 * @inheritdoc
 */
class TextMapper extends AbstractMapper
{
    /**
     * @inheritdoc
     */
    protected function setRelated()
    {
      $this->manyToOne('submitter', UserMapper::CLASS)
          ->on([
              'submitter_id' => 'id',
          ]);
    }
}
