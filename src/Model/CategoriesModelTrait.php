<?php
namespace GreenCheap\Blog\Model;

use GreenCheap\Database\ORM\ModelTrait;

trait CategoriesModelTrait
{
    use ModelTrait;

    /**
     * @Saving
     */
    public static function saving($event, Categories $category)
    {
        $i  = 2;
        $id = $category->id;

        while (self::where('slug = ?', [$category->slug])->where(function ($query) use ($id) {
            if ($id) {
                $query->where('id <> ?', [$id]);
            }
        })->first()) {
            $category->slug = preg_replace('/-\d+$/', '', $category->slug).'-'.$i++;
        }
    }
}
