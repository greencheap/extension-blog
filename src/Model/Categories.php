<?php
namespace GreenCheap\Blog\Model;

use GreenCheap\Application as App;
use GreenCheap\System\Model\DataModelTrait;
use GreenCheap\System\Model\StatusModelTrait;
use GreenCheap\User\Model\AccessModelTrait;

/**
 * Class Categories
 * @package GreenCheap\Blog\Model
 * @Entity(tableClass="@blog_categories")
 */
class Categories implements \JsonSerializable
{
    use CategoriesModelTrait, DataModelTrait, StatusModelTrait, AccessModelTrait;

    /**
     * @Id
     * @Column(type="integer")
     */
    public $id;

    /**
     * @Column(type="string")
     */
    public $title;

    /**
     * @Column(type="string")
     */
    public $slug;

    /**
     * @Column(type="integer")
     */
    public $user_id;

    /**
     * @Column(type="datetime")
     */
    public $date;

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
        'accessible' => 'isAccessible'
    ];

    /**
     * @return null|string
     */
    public function getAuthor()
    {
        return $this->user ? $this->user->username : null;
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
     * @return array
     */
    public function jsonSerialize(): array
    {
        $data = [
            'url' => App::url('@blog/category/id', ['id' => $this->id ?: 0], 'base')
        ];
        return $this->toArray($data);
    }
}

?>
