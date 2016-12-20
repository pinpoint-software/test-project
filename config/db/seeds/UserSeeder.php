<?php

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
        $rows = $this->fetchRow('SELECT COUNT(*) as `c` FROM `users`');

        if (0 === intval($rows['c'])):

        $data = array(
          array(
              'email' => 'admin@pinpointsoftware.co',
              'password' => password_hash('p4ssw0rd!', PASSWORD_DEFAULT),
              'first_name' => 'Pinpoint',
              'last_name' => 'Admin',
              'created' => date('Y-m-d H:i:s'),
              'updated' => date('Y-m-d H:i:s'),
          )
        );

        $users = $this->table('users');
        $users->insert($data)->save();

        endif;
    }
}
