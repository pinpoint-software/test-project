<?php

use Phinx\Seed\AbstractSeed;

class TextsSeeder extends AbstractSeed
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
        $rows = $this->fetchRow('SELECT COUNT(*) as `c` FROM `texts`');

        if (0 === intval($rows['c'])):

        $data = array(
          array(
              'title' => 'An Example Message',
              'text' => 'Here there would be an example message about something!',
              'submitter_id' => 1,
              'created' => date('Y-m-d H:i:s'),
              'updated' => date('Y-m-d H:i:s'),
          ),
          array(
              'title' => 'Shipping Delays',
              'text' => 'There are going to be shipping delays for an item you ordered online.',
              'submitter_id' => 1,
              'created' => date('Y-m-d H:i:s', strtotime('-1 minute')),
              'updated' => date('Y-m-d H:i:s', strtotime('-1 minute')),
          ),
        );

        $links = $this->table('texts');
        $links->insert($data)->save();

        endif;
    }
}
