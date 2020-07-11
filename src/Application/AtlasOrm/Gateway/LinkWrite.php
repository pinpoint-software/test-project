<?php
namespace Application\AtlasOrm\Gateway;

use Application\AtlasOrm\DataSource\Link\LinkMapper;
use Application\Domain\Gateway\LinkWrite as LinkWriteGateway;
use Atlas\Orm\Atlas;
use DateTime;
use Exception;

class LinkWrite implements LinkWriteGateway
{
    private $atlas;

    public function __construct(Atlas $atlas)
    {
        $this->atlas = $atlas;
    }

    public function create($title, $url, $text, $submitterId, DateTime $created)
    {
        $links = [];

        $linkRecord = $this->atlas->newRecord(LinkMapper::CLASS);

        $linkRecord->title = $title;
        $linkRecord->url = $url;
		$linkRecord->text = $text;
        $linkRecord->submitter_id = $submitterId;
        $linkRecord->created = $created->format('Y-m-d H:i:s');
        $linkRecord->updated = $created->format('Y-m-d H:i:s');

        $success = $this->atlas->insert($linkRecord);

        if (false === $success) {
            throw new Exception($this->atlas->getException()->getMessage());
        }
    }
}
