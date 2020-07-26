<?php

namespace GreenCheap\Blog\Model;

use GreenCheap\Database\ORM\ModelTrait;
use GreenCheap\System\Model\DataModelTrait;
use GreenCheap\System\Model\StatusModelTrait;
use GreenCheap\User\Model\AccessModelTrait;

/**
 * Class Post
 * @package GreenCheap\Blog\Model
 * @Entity(tableClass="@blog_post")
 */
class Post implements \JsonSerializable
{
    use ModelTrait, AccessModelTrait, DataModelTrait, StatusModelTrait;

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
     * @var array
     */
    protected static $properties = [];

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
