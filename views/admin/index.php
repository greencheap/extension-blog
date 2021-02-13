<?php $view->script('post-index', 'blog:app/bundle/post-index.js', ['vue']) ?>

<div id="app" v-cloak>

    <div class="uk-margin uk-flex uk-flex-between uk-flex-wrap" >
        <div class="uk-flex uk-flex-middle uk-flex-wrap" >

            <h2 class="uk-h3 uk-margin-remove" v-if="!selected.length">{{ '{0} %count% Posts|{1} %count% Post|]1,Inf[ %count% Posts' | transChoice(count, {count:count}) }}</h2>

            <template v-else>
                <h2 class="uk-h3 uk-margin-remove">{{ '{1} %count% Post selected|]1,Inf[ %count% Posts selected' | transChoice(selected.length, {count:selected.length}) }}</h2>

                <div class="uk-margin-left" >
                    <ul class="uk-iconnav">
                        <li><a uk-icon="icon:check;ratio:1" :uk-tooltip="'Publish' | trans" @click="status(3)"></a></li>
                        <li><a uk-icon="icon:ban;ratio:1" :uk-tooltip="'Unpublish' | trans" @click="status(2)"></a></li>
                        <li><a uk-icon="icon:copy;ratio:1" :uk-tooltip="'Copy' | trans" @click="copy"></a></li>
                        <li><a uk-icon="icon:trash;ratio:1" :uk-tooltip="'Delete' | trans" @click="remove" v-confirm="'Delete Posts?'"></a></li>
                    </ul>
                </div>
            </template>

            <div class="uk-search uk-search-default pk-search">
                <span uk-search-icon></span>
                <input class="uk-search-input" type="search" v-model="config.filter.search" debounce="300">
            </div>

        </div>
        <div >

            <a class="uk-button uk-button-primary" :href="$url.route('admin/blog/post/edit')">{{ 'Add Post' | trans }}</a>

        </div>
    </div>

    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-hover uk-table-middle">
            <thead>
                <tr>
                    <th class="pk-table-width-minimum"><input class="uk-checkbox" type="checkbox" v-check-all:selected="{ selector: 'input[name=id]' }" number></th>
                    <th class="pk-table-min-width-200" v-order:title="config.filter.order">{{ 'Title' | trans }}</th>
                    <th class="pk-table-width-100 uk-text-center">
                        <input-filter :title="$trans('Categories')" :value.sync="config.filter.category" :options="categoryOptions" v-model="config.filter.category"></input-filter>
                    </th>
                    <th class="pk-table-width-100 uk-text-center">
                        <input-filter :title="$trans('Status')" :value.sync="config.filter.status" :options="statusOptions" v-model="config.filter.status"></input-filter>
                    </th>
                    <th class="pk-table-width-100">
                        <span v-if="!canEditAll">{{ 'Author' | trans }}</span>
                        <input-filter :title="$trans('Author')" :value.sync="config.filter.author" :options="users" v-model="config.filter.author" v-else></input-filter>
                    </th>
                    <th class="pk-table-width-100" v-order:date="config.filter.order">{{ 'Date' | trans }}</th>
                    <th class="pk-table-width-200 pk-table-min-width-200">{{ 'URL' | trans }}</th>
                </tr>
            </thead>
            <tbody>
                <tr class="check-item" v-for="post in posts" :key="post.id" :class="{'uk-active': active(post)}">
                    <td><input class="uk-checkbox" type="checkbox" name="id" :value="post.id"></td>
                    <td>
                        <a :href="$url.route('admin/blog/post/edit', { id: post.id })">{{ post.title }}</a>
                    </td>
                    <td class="uk-text-center">
                        <span v-if="post.categories.length > 3" class="uk-text-meta" style="cursor:help" :uk-tooltip="getCategoriesText(post.categories)">{{'Categories' | trans}}</span>
                        <a v-else v-for="category in post.categories" :key="category.id" :href="$url.route('admin/blog/categories/edit', { id: category.id })" target="_blank">
                            {{category.title}}
                        </a>
                    </td>
                    <td class="uk-text-center">
                        <a :title="getStatusText(post)" :class="{
                                'pk-icon-circle': post.status == 0,
                                'pk-icon-circle-warning': post.status == 1,
                                'pk-icon-circle-success': post.status == 3 && post.published,
                                'pk-icon-circle-danger': post.status == 2,
                                'pk-icon-schedule': post.status == 3 && !post.published
                            }" @click="toggleStatus(post)"></a>
                    </td>
                    <td>
                        <a :href="$url.route('admin/user/edit', { id: post.user_id })">{{ post.author }}</a>
                    </td>
                    <td class="pk-table-width-100">
                        {{ post.date | date }}
                    </td>
                    <td class="pk-table-text-break">
                        <a target="_blank" v-if="post.accessible && post.url" :href="$url.route(post.url.substr(1))">{{ decodeURI(post.url) }}</a>
                        <span v-if="!post.accessible && post.url">{{ decodeURI(post.url) }}</span>
                        <span v-if="!post.url">{{ 'Disabled' | trans }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <h3 class="uk-h2 uk-text-muted uk-text-center" v-show="posts && !posts.length">{{ 'No posts found.' | trans }}</h3>

    <!-- <v-pagination :current.sync="config.page" :pages="pages" v-show="pages > 1 || config.page > 0" v-model="config.page"></v-pagination> -->
    <v-pagination :pages="pages" v-model="config.page" v-show="pages > 1 || config.page > 0"></v-pagination>

</div>
