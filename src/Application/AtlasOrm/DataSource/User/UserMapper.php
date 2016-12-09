<?php
namespace Application\AtlasOrm\DataSource\User;

use Application\AtlasOrm\DataSource\Link\LinkMapper;
use Atlas\Orm\Mapper\AbstractMapper;

/**
 * @inheritdoc
 */
class UserMapper extends AbstractMapper
{
    /**
     * @inheritdoc
     */
    protected function setRelated()
    {
        $this->oneToMany('links', LinkMapper::CLASS)
            ->on([
                'id' => 'submitter_id',
            ]);
    }
}
