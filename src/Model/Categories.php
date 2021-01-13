<?php
namespace GreenCheap\Blog\Model;

use GreenCheap\Database\ORM\ModelTrait;
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
    use ModelTrait, DataModelTrait, StatusModelTrait, AccessModelTrait;

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
     * @var array
     */
    protected static $properties = [];

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}

?>
