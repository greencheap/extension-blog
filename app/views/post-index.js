var Post = {
    name: 'post',
    el: '#app',
    data() {
        return _.merge({
            posts: false,
            config: {
                filter: this.$session.get('posts.filter', { order: 'date desc', limit: 10 }),
            },
            pages: 0,
            count: '',
            selected: [],
            canEditAll: false,
        }, window.$data);
    },

    mounted() {
        this.resource = this.$resource('admin/api/blog/post{/id}');
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

                this.$session.set('posts.filter', filter);
            },
            deep: true,
        }

    },

    computed: {

        statusOptions() {
            const options = _.map(this.statuses, (status, id) => ({ text: status, value: id }));

            return [{ label: this.$trans('Filter by'), options }];
        },

        categoryOptions() {
            const options = _.map(this.categories, (category, id) => ({ text: category.title, value: category.id }));

            return [{ label: this.$trans('Filter by'), options }];
        },

        users() {
            const options = _.map(this.authors, author => ({ text: author.username, value: author.user_id }));

            return [{ label: this.$trans('Filter by'), options }];
        },
    },

    methods: {

        active(post) {
            return this.selected.indexOf(post.id) != -1;
        },

        save(data) {
            this.resource.save({ id: data.id }, { data }).then(function () {
                this.load();
                this.$notify('Post saved.');
            });
        },

        status(status) {
            const posts = this.getSelected();

            posts.forEach((post) => {
                post.status = status;
            });

            this.resource.save({ id: 'bulk' }, { posts }).then(function () {
                this.load();
                this.$notify('Posts saved.');
            });
        },

        remove() {
            this.resource.delete({ id: 'bulk' }, { ids: this.selected }).then(function () {
                this.load();
                this.$notify('Posts deleted.');
            });
        },

        toggleStatus(post) {
            post.status = post.status === 2 ? 3 : 2;
            this.save(post);
        },

        copy() {
            if (!this.selected.length) {
                return;
            }

            this.resource.save({ id: 'copy' }, { ids: this.selected }).then(function () {
                this.load();
                this.$notify('Posts copied.');
            });
        },

        load() {
            this.resource.query({ filter: this.config.filter, page: this.config.page }).then(function (res) {
                const { data } = res;
                this.$set(this, 'posts', data.posts);
                this.$set(this, 'pages', data.pages);
                this.$set(this, 'count', data.count);
                this.$set(this, 'selected', []);
            });
        },

        getSelected() {
            return this.posts.filter(function (post) { return this.selected.indexOf(post.id) !== -1; }, this);
        },

        getStatusText(post) {
            return this.statuses[post.status];
        },

        getCategoriesText(categories){
            let data = [];
            _.forEach(categories , (category) => {
                data.push(category.title);
            })
            return _.join(data, ',');
        }

    }

};

export default Post;

Vue.ready(Post);
