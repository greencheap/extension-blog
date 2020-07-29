<?php
namespace GreenCheap\Blog\Model;

use GreenCheap\Database\ORM\ModelTrait;

trait PostModelTrait
{
    use ModelTrait;

    /**
     * Get all users who have written an article
     */
    public static function getAuthors()
    {
        return self::query()->select('user_id', 'name', 'username')->groupBy('user_id', 'name', 'username')->join('@system_user', 'user_id = @system_user.id')->execute()->fetchAll();
    }

    /**
     * @Saving
     */
    public static function saving($event, Post $post)
    {
        $post->modified = new \DateTime();

        $i  = 2;
        $id = $post->id;

        while (self::where('slug = ?', [$post->slug])->where(function ($query) use ($id) {
            if ($id) {
                $query->where('id <> ?', [$id]);
            }
        })->first()) {
            $post->slug = preg_replace('/-\d+$/', '', $post->slug).'-'.$i++;
        }
    }
}
