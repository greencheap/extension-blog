<?php $view->script('categories-edit', 'blog:app/bundle/categories-edit.js', ['vue', 'editor']) ?>

<form tag="form" id="app" @submit.prevent="submit" v-cloak>
    <div class="uk-flex uk-flex-middle uk-flex-between uk-flex-wrap">
        <div>
            <v-title v-if="category.id" :title="'Edit' | trans"></v-title>
            <v-title v-else :title="'Add' | trans"></v-title>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-text uk-margin-right" :href="$url.route('admin/blog/categories')">{{ category.id ? 'Close' : 'Cancel' | trans }}</a>
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
            <component :is="section.name" :category.sync="category" :data.sync="data"></component>
        </div>
    </div>

</form>
