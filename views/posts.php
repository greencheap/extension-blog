<?php $view->script('posts', 'blog:app/bundle/post.js', 'vue') ?>

<?php foreach ($posts as $post) : ?>
    <article class="uk-article">

        <?php if ($image = $post->get('image.src')): ?>
            <a class="uk-display-block" href="<?= $view->url('@blog/id', ['id' => $post->id]) ?>"><img src="<?= $image ?>" alt="<?= $post->get('image.alt') ?>"></a>
        <?php endif ?>

        <h1 class="uk-article-title"><a href="<?= $view->url('@blog/id', ['id' => $post->id]) ?>"><?= $post->title ?></a></h1>

        <p class="uk-article-meta">
            <?= __('Written by %name% on %date%', ['%name%' => $this->escape($post->user->name), '%date%' => '<time datetime="'.$post->date->format(\DateTime::ATOM).'" v-cloak>{{ "'.$post->date->format(\DateTime::ATOM).'" | date("longDate") }}</time>' ]) ?>
        </p>

        <ul class="uk-subnav">
            <?php foreach($post->getCategories() as $category): ?>
                <li><a href="<?= $view->url('@blog/category/id' , ['id' => $category['id']]) ?>"><?= $category['title'] ?></a></li>
            <?php endforeach ?>
        </ul>

        <div class="uk-margin"><?= $post->excerpt ?: $post->content ?></div>

        <ul class="uk-subnav">

            <?php if (isset($post->readmore) && $post->readmore || $post->excerpt) : ?>
                <li><a href="<?= $view->url('@blog/id', ['id' => $post->id]) ?>"><?= __('Read more') ?></a></li>
            <?php endif ?>
        </ul>

    </article>
<?php endforeach ?>

<?php if(!$posts): ?>
    <div class="uk-section-large uk-text-center">
        <h1><?= __("Not found Posts") ?></h1>
    </div>
<?php endif ?>

<?php

$range     = 3;
$total     = intval($total);
$page      = intval($page);
$pageIndex = $page - 1;

?>

<?php if ($total > 1) : ?>
    <ul class="uk-pagination uk-flex-center">

        <?php for($i=1;$i<=$total;$i++): ?>
            <?php if ($i <= ($pageIndex+$range) && $i >= ($pageIndex-$range)): ?>

                <?php if ($i == $page): ?>
                    <li class="uk-active"><span><?=$i?></span></li>
                <?php else: ?>
                    <li>
                        <a href="<?= $view->url($page_link, array_merge(['page' => $i], $page_params)) ?>"><?=$i?></a>
                    </li>
                <?php endif; ?>

            <?php elseif($i==1): ?>

                <li>
                    <a href="<?= $view->url($page_link, array_merge(['page' => 1], $page_params)) ?>">1</a>
                </li>
                <li><span>...</span></li>

            <?php elseif($i==$total): ?>

                <li><span>...</span></li>
                <li>
                    <a href="<?= $view->url($page_link, array_merge(['page' => $total], $page_params)) ?>"><?=$total?></a>
                </li>

            <?php endif; ?>
        <?php endfor; ?>


    </ul>
<?php endif ?>
