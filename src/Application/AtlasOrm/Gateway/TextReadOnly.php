<?php
namespace Application\AtlasOrm\Gateway;

use Application\AtlasOrm\DataSource\Text\TextMapper;
use Application\Domain\Entity\Text;
use Application\Domain\Entity\User;
use Application\Domain\Gateway\TextReadOnly as TextReadOnlyGateway;
use Atlas\Orm\Atlas;
use DateTime;
use DateTimeZone;

class TextReadOnly implements TextReadOnlyGateway
{
    private $atlas;

    public function __construct(Atlas $atlas)
    {
        $this->atlas = $atlas;
    }

    public function getRecentTexts()
    {
        $texts = [];

        $textRecordSet = $this->atlas
            ->select(TextMapper::class)
            ->orderBy([
                'created DESC',
            ])
            ->with([
                'submitter',
            ])
            ->fetchRecordSet();

        foreach ($textRecordSet as $textRecord) {
            $texts[] = new Text(
                $textRecord->id,
                $textRecord->title,
                $textRecord->text,
                new User(
                    $textRecord->submitter->id,
                    $textRecord->submitter->email,
                    $textRecord->submitter->password,
                    $textRecord->submitter->first_name,
                    $textRecord->submitter->last_name,
                    new DateTime($textRecord->submitter->created, new DateTimeZone('UTC')),
                    new DateTime($textRecord->submitter->updated, new DateTimeZone('UTC'))
                ),
                new DateTime($textRecord->created, new DateTimeZone('UTC')),
                new DateTime($textRecord->updated, new DateTimeZone('UTC'))
            );
        }

        return $texts;
    }

    public function getText($id)
    {
        $text = $this->atlas->select(TextMapper::class)
                    ->where('id = ?', $id)
                    ->cols(['id', 'title', 'text'])
                    ->fetchRecord();

        return $text;
    }
}
