<?php
namespace Application\AtlasOrm\Gateway;

use Application\AtlasOrm\DataSource\Text\TextMapper;
use Application\Domain\Gateway\TextWrite as TextWriteGateway;
use Atlas\Orm\Atlas;
use DateTime;
use Exception;

class TextWrite implements TextWriteGateway
{
    private $atlas;

    public function __construct(Atlas $atlas)
    {
        $this->atlas = $atlas;
    }

    public function create($title, $text, $submitterId, DateTime $created)
    {
        $texts = [];

        $textRecord = $this->atlas->newRecord(TextMapper::CLASS);

        $textRecord->title = $title;
        $textRecord->text = $text;
        $textRecord->submitter_id = $submitterId;
        $textRecord->created = $created->format('Y-m-d H:i:s');
        $textRecord->updated = $created->format('Y-m-d H:i:s');

        $success = $this->atlas->insert($textRecord);

        if (false === $success) {
            throw new Exception($this->atlas->getException()->getMessage());
        }
    }
}
