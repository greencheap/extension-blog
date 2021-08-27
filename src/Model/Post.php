<?php
namespace GreenCheap\Blog\Model;

use GreenCheap\Application as App;
use GreenCheap\System\Model\DataModelTrait;
use GreenCheap\System\Model\StatusModelTrait;
use GreenCheap\System\Service\StatusModelService;
use GreenCheap\User\Model\AccessModelTrait;

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
        $categories = $this->categories_id;
        if($categories){
            $db = App::db();
            return $db->createQueryBuilder()
                ->from('@blog_categories')
                ->where('status = ?' , [StatusModelService::getStatus('STATUS_PUBLISHED')])
                ->whereIn('id', $categories)
                ->get();
        }
        return false;
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
    public function isAccessible(User $user = null): bool
    {
        return $this->isPublished() && $this->hasAccess($user ?: App::user());
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return App::url('@blog/id', ['id' => $this->id ?: 0], 'base');
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $data = [
            'url' => $this->getUrl()
        ];

        return $this->toArray($data);
    }
}
