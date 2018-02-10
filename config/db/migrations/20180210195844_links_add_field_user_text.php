<?php

use Phinx\Migration\AbstractMigration;

class LinksAddFieldUserText extends AbstractMigration
{
    /**
     * up()
     *
     *      Adds the column 'user_text' to the links table when migrating up.
     */
    public function up()
    {
        $links = $this->table('links');
        $links->addColumn('user_text', 'text', array('null' => true))
              ->save();
    }

    public function down()
    {
    }
}
