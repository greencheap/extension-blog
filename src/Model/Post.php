<?php
namespace GreenCheap\Blog\Model;

use GreenCheap\Application as App;
use GreenCheap\System\Model\DataModelTrait;
use GreenCheap\System\Model\StatusModelTrait;
use GreenCheap\User\Model\AccessModelTrait;
use GreenCheap\Blog\Model\Categories;

/**
 * Class Post
 * @package GreenCheap\Blog\Model
 * @Entity(tableClass="@blog_post")
 */
class Post implements \JsonSerializable
{
    use AccessModelTrait, DataModelTrait, StatusModelTrait, PostModelTrait;

    /**
     * @Column(type="integer")
     * @Id
     */
    public $id;

    /**
     * @Column(type="integer")
     */
    public $user_id;

    /**
     * @Column(type="simple_array")
     */
    public $categories_id;

    /**
     * @Column
     */
    public $title;

    /**
     * @Column
     */
    public $slug;

    /**
     * @Column(type="datetime")
     */
    public $date;

    /**
     * @Column(type="datetime")
     */
    public $modified;

    /**
     * @Column(type="text")
     */
    public $content;

    /**
     * @Column(type="text")
     */
    public $excerpt;

    /**
     * @BelongsTo(targetEntity="GreenCheap\User\Model\User", keyFrom="user_id")
     */
    public $user;

    /**
     * @var array
     */
    protected static $properties = [
        'author' => 'getAuthor',
        'published' => 'isPublished',
        'accessible' => 'isAccessible',
        'categories' => 'getCategories'
    ];

    /**
     * @return null|string
     */
    public function getAuthor()
    {
        return $this->user ? $this->user->username : null;
    }

    /**
     * return Categories
     */
    public function getCategories()
    {
        $categories_id = $this->categories_id;

        $db = App::db();
        $query = $db->createQueryBuilder()
        ->from('@blog_categories')
        ->where('status = :status', ['status' => Categories::getStatus('STATUS_PUBLISHED')])
        ->where(function($query)use($categories_id){
            $query->whereIn('id' , $categories_id);
        });
        $categories = $query->get();
        return $categories;
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->status === self::getStatus('STATUS_PUBLISHED') && $this->date < new \DateTime;
    }

    /**
     * @param User|null $user
     * @return bool
     */
    public function isAccessible(User $user = null)
    {
        return $this->isPublished() && $this->hasAccess($user ?: App::user());
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $data = [
            'url' => App::url('@blog/id', ['id' => $this->id ?: 0], 'base')
        ];

        return $this->toArray($data);
    }
}
