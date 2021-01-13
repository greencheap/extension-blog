<?php $view->script('categories-index', 'blog:app/bundle/categories-index.js', ['vue']) ?>

<section id="app">
    <div class="uk-clearfix">
        <div>
            <a :href="$url.route('admin/blog/categories/edit')">Add</a>
        </div>
    </div>
</section>
