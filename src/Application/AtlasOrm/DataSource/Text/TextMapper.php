<?php
namespace Application\DataSource\Text;

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
        // no related fields
    }
}
