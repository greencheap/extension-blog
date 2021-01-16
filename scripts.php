<?php

use Doctrine\DBAL\Schema\Comparator;

return [
    'enable' => function($app)
    {
        $util = $app['db']->getUtility();
        if (!$util->tableExists('@blog_post')) {
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

        if(!$util->tableExists('@blog_categories')){
            $util->createTable('@blog_categories', function($table){
                $table->addColumn('id', 'integer' , ['unsigned' => true , 'length' => 10 , 'autoincrement' => true]);
                $table->addColumn('title', 'string');
                $table->addColumn('slug', 'string');
                $table->addColumn('user_id' , 'integer');
                $table->addColumn('status', 'smallint');
                $table->addColumn('date', 'datetime', ['notnull' => false]);
                $table->addColumn('excerpt', 'text', ['notnull' => false]);
                $table->addColumn('roles', 'simple_array', ['notnull' => false]);
                $table->addColumn('data', 'json_array', ['notnull' => false]);
                $table->setPrimaryKey(['id']);
                $table->addIndex(['title'] , '@BLOG_CATEGORIES_TITLE');
                $table->addIndex(['slug'] , '@BLOG_CATEGORIES_SLUG');
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

    'update' => [
        '2.0.0' => function($app)
        {
            $util = $app['db']->getUtility();
            if(!$util->tableExists('@blog_categories')){
                $util->createTable('@blog_categories', function($table){
                    $table->addColumn('id', 'integer' , ['unsigned' => true , 'length' => 10 , 'autoincrement' => true]);
                    $table->addColumn('title', 'string');
                    $table->addColumn('slug', 'string');
                    $table->addColumn('user_id' , 'integer');
                    $table->addColumn('status', 'smallint');
                    $table->addColumn('date', 'datetime', ['notnull' => false]);
                    $table->addColumn('excerpt', 'text', ['notnull' => false]);
                    $table->addColumn('roles', 'simple_array', ['notnull' => false]);
                    $table->addColumn('data', 'json_array', ['notnull' => false]);
                    $table->setPrimaryKey(['id']);
                    $table->addIndex(['title'] , '@BLOG_CATEGORIES_TITLE');
                    $table->addIndex(['slug'] , '@BLOG_CATEGORIES_SLUG');
                });
            }
        }
    ]
];
?>
