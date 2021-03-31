<?php $view->script('post', 'blog:app/bundle/post.js', 'vue') ?>

<article class="uk-article">

    <?php if ($image = $post->get('image.src')) : ?>
        <img src="<?= $image ?>" alt="<?= $post->get('image.alt') ?>">
    <?php endif ?>

    <h1 class="uk-article-title"><?= $post->title ?></h1>

    <p class="uk-article-meta">
        <?= __('Written by %name% on %date%', ['%name%' => $this->escape($post->user->name), '%date%' => '<time datetime="' . $post->date->format(\DateTime::ATOM) . '" v-cloak>{{ "' . $post->date->format(\DateTime::ATOM) . '" | date("longDate") }}</time>']) ?>
    </p>

    <ul class="uk-subnav">
        <?php foreach ($post->getCategories() as $category) : ?>
            <li><a href="<?= $view->url('@blog/category/id', ['id' => $category['id']]) ?>"><?= $category['title'] ?></a></li>
        <?php endforeach ?>
    </ul>

    <div class="uk-margin"><?= $post->content ?></div>

    <?php if ($post->get('comment_status')) : ?>
        <?= $view->render('system/comment:views/comment.php', [
            'service' => [
                'type' => 'blog',
                'own_id' => $post->id,
                'type_url' => [
                    'url' => '@blog/id',
                    'key' => 'id',
                ]
            ]
        ]) ?>
    <?php endif ?>

</article>