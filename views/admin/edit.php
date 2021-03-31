<?php $view->script('post-edit', 'blog:app/bundle/post-edit.js', ['vue', 'editor', 'multi-finder']) ?>

<form tag="form" id="app" @submit.prevent="submit" v-cloak>
    <div class="uk-flex uk-flex-middle uk-flex-between uk-flex-wrap">
        <div class="">
            <h2 class="uk-margin-remove" v-if="post.id">{{ 'Edit' }}</h2>
            <h2 class="uk-margin-remove" v-else>{{ 'Add' }}</h2>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-text uk-margin-right" :href="$url.route('admin/blog/post')">{{ post.id ? 'Close' : 'Cancel' | trans }}</a>
            <button class="uk-button uk-button-primary" type="submit">
                {{ 'Save' | trans }}
            </button>
        </div>
    </div>
    <ul ref="tab" v-show="sections.length > 1" id="tab">
        <li v-for="section in sections" :key="section.name"><a>{{ section.label | trans }}</a></li>
    </ul>

    <div ref="content" class="uk-switcher uk-margin" id="content">
        <div v-for="section in sections" :key="section.name">
            <component :is="section.name" :post.sync="post" :data.sync="data"></component>
        </div>
    </div>

</form>