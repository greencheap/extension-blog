<?php 
return [
    'enable' => function($app)
    {
        $util = $app['db']->getUtility();
        if ($util->tableExists('@blog_post') === false) {
            $util->createTable('@blog_post', function ($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('user_id', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('categories_id', 'simple_array' , ['notnull' => false]);
                $table->addColumn('slug', 'string', ['length' => 255]);
                $table->addColumn('title', 'string', ['length' => 255]);
                $table->addColumn('status', 'smallint');
                $table->addColumn('date', 'datetime', ['notnull' => false]);
                $table->addColumn('modified', 'datetime');
                $table->addColumn('content', 'text', ['notnull' => false]);
                $table->addColumn('excerpt', 'text', ['notnull' => false]);
                $table->addColumn('data', 'json_array', ['notnull' => false]);
                $table->addColumn('roles', 'simple_array', ['notnull' => false]);
                $table->setPrimaryKey(['id']);
                $table->addUniqueIndex(['slug'], '@BLOG_POST_SLUG');
                $table->addIndex(['title'], '@BLOG_POST_TITLE');
                $table->addIndex(['user_id'], '@BLOG_POST_USER_ID');
                $table->addIndex(['date'], '@BLOG_POST_DATE');
            });
        }
    },

    'uninstall' => function($app)
    {
        $util = $app['db']->getUtility();
        if ($util->tableExists('@blog_post')) {
            $util->dropTable('@blog_post');
        }
    },

    'install' => function($app)
    {
        $util = $app['db']->getUtility();
    },

    'update' => function($app)
    {

    }
];
?>