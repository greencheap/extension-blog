<?php $view->script('categories-index', 'blog:app/bundle/categories-index.js', ['vue']) ?>

<div id="app" v-cloak>

    <div class="uk-margin uk-flex uk-flex-between uk-flex-wrap" >
        <div class="uk-flex uk-flex-middle uk-flex-wrap" >

            <h2 class="uk-h3 uk-margin-remove" v-if="!selected.length">{{ '{0} %count% Categories|{1} %count% Category|]1,Inf[ %count% Categories' | transChoice(count, {count:count}) }}</h2>

            <template v-else>
                <h2 class="uk-h3 uk-margin-remove">{{ '{1} %count% Category selected|]1,Inf[ %count% Categories selected' | transChoice(selected.length, {count:selected.length}) }}</h2>

                <div class="uk-margin-left" >
                    <ul class="uk-iconnav">
                        <li><a uk-icon="icon:check;ratio:1" :uk-tooltip="'Publish' | trans" @click="status(3)"></a></li>
                        <li><a uk-icon="icon:ban;ratio:1" :uk-tooltip="'Unpublish' | trans" @click="status(2)"></a></li>
                        <li><a uk-icon="icon:copy;ratio:1" :uk-tooltip="'Copy' | trans" @click="copy"></a></li>
                        <li><a uk-icon="icon:trash;ratio:1" :uk-tooltip="'Delete' | trans" @click="remove" v-confirm="'Delete Categories?'"></a></li>
                    </ul>
                </div>
            </template>

            <div class="uk-search uk-search-default pk-search">
                <span uk-search-icon></span>
                <input class="uk-search-input" type="search" v-model="config.filter.search" debounce="300">
            </div>

        </div>
        <div>
            <a class="uk-button uk-button-primary" :href="$url.route('admin/blog/categories/edit')">{{ 'Add Category' | trans }}</a>
        </div>
    </div>

    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-hover uk-table-middle">
            <thead>
                <tr>
                    <th class="pk-table-width-minimum"><input class="uk-checkbox" type="checkbox" v-check-all:selected="{ selector: 'input[name=id]' }" number></th>
                    <th class="pk-table-min-width-200" v-order:title="config.filter.order">{{ 'Title' | trans }}</th>
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
                <tr class="check-item" v-for="category in categories" :key="category.id" :class="{'uk-active': active(category)}">
                    <td><input class="uk-checkbox" type="checkbox" name="id" :value="category.id"></td>
                    <td>
                        <a :href="$url.route('admin/blog/categories/edit', { id: category.id })">{{ category.title }}</a>
                    </td>
                    <td class="uk-text-center">
                        <a :title="getStatusText(category)" :class="{
                                'pk-icon-circle': category.status == 0,
                                'pk-icon-circle-warning': category.status == 1,
                                'pk-icon-circle-success': category.status == 3 && category.published,
                                'pk-icon-circle-danger': category.status == 2,
                                'pk-icon-schedule': category.status == 3 && !category.published
                            }" @click="toggleStatus(category)"></a>
                    </td>
                    <td>
                        <a :href="$url.route('admin/user/edit', { id: category.user_id })">{{ category.author }}</a>
                    </td>
                    <td class="pk-table-width-100">
                        {{ category.date | date }}
                    </td>
                    <td class="pk-table-text-break">
                        <a target="_blank" v-if="category.accessible && category.url" :href="$url.route(category.url.substr(1))">{{ decodeURI(category.url) }}</a>
                        <span v-if="!category.accessible && category.url">{{ decodeURI(category.url) }}</span>
                        <span v-if="!category.url">{{ 'Disabled' | trans }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <h3 class="uk-h2 uk-text-muted uk-text-center" v-show="categories && !categories.length">{{ 'No categories found.' | trans }}</h3>

    <v-pagination :pages="pages" v-model="config.page" v-show="pages > 1 || config.page > 0"></v-pagination>
</div>
