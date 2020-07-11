<?php
namespace Application\AtlasOrm\Gateway;

use Application\AtlasOrm\DataSource\Link\LinkMapper;
use Application\Domain\Entity\Link;
use Application\Domain\Entity\User;
use Application\Domain\Gateway\LinkReadOnly as LinkReadOnlyGateway;
use Atlas\Orm\Atlas;
use DateTime;
use DateTimeZone;

class LinkReadOnly implements LinkReadOnlyGateway
{
    private $atlas;

    public function __construct(Atlas $atlas)
    {
        $this->atlas = $atlas;
    }
	
	public function getLinkById(int $id)
	{
		$linkRecord = $this->atlas
            ->select(LinkMapper::Class)
            ->where('id = ?', $id)
			->with(['submitter',])
            ->fetchRecord();
			
		return new Link(
			$linkRecord->id,
			$linkRecord->title,
			$linkRecord->url,
			$linkRecord->text,
			new User(
				$linkRecord->submitter->id,
				$linkRecord->submitter->email,
				$linkRecord->submitter->password,
				$linkRecord->submitter->first_name,
				$linkRecord->submitter->last_name,
				new DateTime($linkRecord->submitter->created, new DateTimeZone('UTC')),
				new DateTime($linkRecord->submitter->updated, new DateTimeZone('UTC'))
			),
			new DateTime($linkRecord->created, new DateTimeZone('UTC')),
			new DateTime($linkRecord->updated, new DateTimeZone('UTC'))
		);
	}

    public function getRecentLinks()
    {
        $links = [];

        $linkRecordSet = $this->atlas
            ->select(LinkMapper::class)
            ->orderBy([
                'created DESC',
            ])
            ->with([
                'submitter',
            ])
            ->fetchRecordSet();

        foreach ($linkRecordSet as $linkRecord) {
            $links[] = new Link(
                $linkRecord->id,
                $linkRecord->title,
                $linkRecord->url,
				$linkRecord->text,
                new User(
                    $linkRecord->submitter->id,
                    $linkRecord->submitter->email,
                    $linkRecord->submitter->password,
                    $linkRecord->submitter->first_name,
                    $linkRecord->submitter->last_name,
                    new DateTime($linkRecord->submitter->created, new DateTimeZone('UTC')),
                    new DateTime($linkRecord->submitter->updated, new DateTimeZone('UTC'))
                ),
                new DateTime($linkRecord->created, new DateTimeZone('UTC')),
                new DateTime($linkRecord->updated, new DateTimeZone('UTC'))
            );
        }

        return $links;
    }
}
