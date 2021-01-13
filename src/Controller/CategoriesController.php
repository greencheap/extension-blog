<?php


namespace GreenCheap\Blog\Controller;

use GreenCheap\Application as App;
use GreenCheap\Blog\Model\Categories;
use GreenCheap\System\Service\StatusModelService;
use GreenCheap\User\Model\User;


/**
 * Class CategoriesController
 * @package GreenCheap\Blog\Controller
 * @Access("blog: manage all posts" , admin=true)
 * @Route("/categories" , name="admin/categories")
 */
class CategoriesController
{
    /**
     * @param array $filter
     * @param int $page
     * @return array|string
     * @Request({"filter":"array" , "page":"int"})
     */
    public function indexAction(array $filter = [] , int $page = 1): array|string
    {
        $db = App::db();

        return [
            '$view' => [
                'title' => __('Categories'),
                'name' => 'blog:views/admin/categories-index.php'
            ],
            '$data' => [
                'config' => [
                    'filter' => (object) $filter,
                    'page' => (int) $page
                ],

            ]
        ];
    }

    /**
     * @Request({"id":"integer"})
     * @param int $id
     * @return array
     */
    public function editAction(int $id = 0): array
    {
        if(!$query = Categories::where(compact('id'))->first()){
            if($id){
                return App::abort(404 , __('Not Found Category'));
            }

            $query = Categories::create([
                'date' => new \DateTime(),
                'user_id' => App::user()->id,
                'status' => StatusModelService::getStatus('STATUS_DRAFT')
            ]);
        }

        return [
            '$view' => [
                'title' => $query->id ? __('Edit %title%' , ['%title%' => $query->title]) : __('New Category'),
                'name' => 'blog:views/admin/categories-edit.php'
            ],
            '$data' => [
                'category' => $query
            ]
        ];

    }
}
