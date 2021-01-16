const CategoriesIndex = {
    el: '#app',
    name: 'CategoriesIndex',
    data(){
        return _.merge({
            categories: false,
            config: {
                filter: this.$session.get('categories.filter', { order: 'date desc', limit: 10 }),
            },
            pages: 0,
            count: '',
            selected: [],
            canEditAll: false,
        }, window.$data)
    },

    mounted() {
        this.resource = this.$resource('admin/api/blog/category{/id}');
        this.$watch('config.page', this.load, { immediate: true });
    },

    watch: {
        'config.filter': {
            handler(filter) {
                if (this.config.page) {
                    this.config.page = 0;
                } else {
                    this.load();
                }
                this.$session.set('categories.filter', filter);
            },
            deep: true,
        }
    },

    computed: {

        statusOptions() {
            const options = _.map(this.$data.statuses, (status, id) => ({ text: status, value: id }));
            return [{ label: this.$trans('Filter by'), options }];
        },

        users() {
            const options = _.map(this.$data.authors, author => ({ text: author.username, value: author.user_id }));
            return [{ label: this.$trans('Filter by'), options }];
        },
    },

    methods:{
        load(){
            this.resource.query({ filter: this.config.filter, page: this.config.page }).then(function (res) {
                const { data } = res;
                this.$set(this, 'categories', data.categories);
                this.$set(this, 'pages', data.pages);
                this.$set(this, 'count', data.count);
                this.$set(this, 'selected', []);
            });
        },

        active(category) {
            return this.selected.indexOf(category.id) != -1;
        },

        save(data) {
            this.resource.save({ id: data.id }, { data }).then(function () {
                this.load();
                this.$notify('Category saved.');
            });
        },

        status(status) {
            const categories = this.getSelected();

            categories.forEach((category) => {
                category.status = status;
            });

            this.resource.save({ id: 'bulk' }, { categories }).then(function () {
                this.load();
                this.$notify('Categories saved.');
            });
        },

        remove() {
            this.resource.delete({ id: 'bulk' }, { ids: this.selected }).then(function () {
                this.load();
                this.$notify('Categories deleted.');
            });
        },

        toggleStatus(category) {
            category.status = category.status === 2 ? 3 : 2;
            this.save(category);
        },

        copy() {
            if (!this.selected.length) {
                return;
            }

            this.resource.save({ id: 'copy' }, { ids: this.selected }).then(function () {
                this.load();
                this.$notify('Categories copied.');
            });
        },

        getSelected() {
            return this.categories.filter(function (category) { return this.selected.indexOf(category.id) !== -1; }, this);
        },

        getStatusText(category) {
            return this.statuses[category.status];
        },
    }
}

Vue.ready(CategoriesIndex)
