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

    /*
     * createLinkInkstance($linkRecord)
     *
     *      Takes in an AtlasORM Record object for the links table and returns
     *      a corresponding new Link intances with the given data.
     *
     * @param Atlas\Orm\Mapper\Record $linkRecord - Should be instantiated with
     *                                      the correct data.
     * @return An instance of Application\Domain\Entiy\Link
     *
     */
    private function createLinkInstance($linkRecord) {
        return new Link(
            $linkRecord->id,
            $linkRecord->title,
            $linkRecord->url,
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
            new DateTime($linkRecord->updated, new DateTimeZone('UTC')),
            $linkRecord->user_text
        );
    }

    public function __construct(Atlas $atlas)
    {
        $this->atlas = $atlas;
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
            $links[] = self::createLinkInstance($linkRecord);
        }

        return $links;
    }

    /*
     * getLinkById($id)
     *
     *      Returns the database record for the given database id.
     *
     * @return An instance of the Application\Domain\Entity\Link class
     *          instantiated with the data from the queried record.
     *          Returns null if the record was not found.
     */
    public function getLinkById($id)
    {
        $linkRecord = $this->atlas
            ->select(LinkMapper::class)
            ->where('id = ?', $id)
            ->with([
                'submitter',
            ])
            ->fetchRecord();
        if ($linkRecord) {
            return self::createLinkInstance($linkRecord);
        } else {
            return null;
        }

    }

}
