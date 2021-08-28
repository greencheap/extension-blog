<?php
namespace GreenCheap\Blog\Sitemaps;

use GreenCheap\Application as App;
use GreenCheap\Blog\Model\Post;
use GreenCheap\Module\Module;
use GreenCheap\Seo\SitemapInterface;
use GreenCheap\Seo\Sitemaps;

class BlogSitemap implements SitemapInterface
{
    /**
     * @var Module
     */
    protected Module $blog;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->blog = App::module('blog');
    }

    /**
     * @param int $page
     */
    public function getData($page = 0): array
    {
        $data = [];
        if($page == 0){
            for ($i = 1; $i <= $this->getPages(); $i++){
                $data[] = [
                    "url" => [
                        "loc" => App::url('@sitemap/page', ["sitemap" => "blog", "page" => $i], 0),
                    ],
                ];
            }

            krsort($data);
        }else{
            foreach ($this->getPosts($page) as $post) {
                $data[] = [
                    "url" => [
                        "loc" => App::url('@blog/id', ['id' => $post->id ?: 0], 0),
                        "lastmod" => $post->date->format(Sitemaps::getLastModFormat()),
                    ],
                ];
            }
        }

        return $data;
    }

    /**
     * @param $page
     * @return mixed
     */
    protected function getPosts($page): mixed
    {
        $page = $page == 0 ? 1 : $page;

        $query = Post::query()->where(['status = :status', 'date < :date'], ['status' => Post::getStatus('STATUS_PUBLISHED'), 'date' => new \DateTime])->where(function ($query) {
            return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
        });

        $limit = Sitemaps::getPerLimit();

        $count = $query->count('id');
        $total = ceil($count / $limit);
        $page = max(1, min($total, $page));

        $query->offset(($page - 1) * $limit)->limit($limit)->orderBy('date', 'DESC');
        return $query->get();
    }

    protected function getPages()
    {
        $query = Post::query()->where(['status = :status', 'date < :date'], ['status' => Post::getStatus('STATUS_PUBLISHED'), 'date' => new \DateTime])->where(function ($query) {
            return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
        });

        return $query->count();
    }
}

?>
