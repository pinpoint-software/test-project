<?php

use Phinx\Seed\AbstractSeed;

class LinkSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $rows = $this->fetchRow('SELECT COUNT(*) as `c` FROM `links`');

        if (0 === intval($rows['c'])):

        $data = array(
          array(
              'title' => 'Pinpoint Software',
              'url' => 'http://www.pinpointsoftware.co/',
			  'text' => '',
              'submitter_id' => 1,
              'created' => date('Y-m-d H:i:s'),
              'updated' => date('Y-m-d H:i:s'),
          ),
          array(
              'title' => 'Date Check Pro',
              'url' => 'http://www.datecheckpro.com/',
			  'text' => '',
              'submitter_id' => 1,
              'created' => date('Y-m-d H:i:s', strtotime('-1 minute')),
              'updated' => date('Y-m-d H:i:s', strtotime('-1 minute')),
          ),
          array(
              'title' => 'Taskle',
              'url' => 'http://www.taskle.com/',
			  'text' => '',
              'submitter_id' => 1,
              'created' => date('Y-m-d H:i:s', strtotime('-3 minutes')),
              'updated' => date('Y-m-d H:i:s', strtotime('-3 minutes')),
          ),
          array(
              'title' => 'Stop Waste Together',
              'url' => 'http://www.stopwastetogether.com/',
			  'text' => '',
              'submitter_id' => 1,
              'created' => date('Y-m-d H:i:s', strtotime('-10 minutes')),
              'updated' => date('Y-m-d H:i:s', strtotime('-10 minutes')),
          ),
        );

        $links = $this->table('links');
        $links->insert($data)->save();

        endif;
    }
}
