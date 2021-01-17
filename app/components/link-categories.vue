<template>
    <div class="uk-margin">
        <label for="form-link-blog" class="uk-form-label">{{ 'View' | trans }}</label>
        <div class="uk-form-controls">
            <select id="form-link-blog" v-model="category" class="uk-width-1-1 uk-select">
                <option value="@blog">
                    {{ 'Posts View' | trans }}
                </option>
                <optgroup :label="'Categories' | trans">
                    <option v-for="category in categories" :value="category | link" :key="category.id">
                        {{ category.title }}
                    </option>
                </optgroup>
            </select>
        </div>
    </div>
</template>

<script>

var LinkCategories = {

    link: {
        label: 'Categories',
    },

    props: ['link'],

    data() {
        return {
            categories: [],
            category: '',
        };
    },

    created() {
        this.$http.get('admin/api/blog/category', { params: { filter: { limit: 1000 } } }).then(function (res) {
            this.$set(this, 'categories', res.data.categories);
        });
    },

    mounted() {
        this.category = '@blog';
    },

    watch: {

        category(category) {
            this.$parent.link = category;
        },

    },

    filters: {

        link(category) {
            return `@blog/category/id?id=${category.id}`;
        },

    },

};

export default LinkCategories;

window.Links.default.components['link-categories'] = LinkCategories;

</script>
