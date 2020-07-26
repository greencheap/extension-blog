/* eslint-disable no-restricted-syntax */
import Section from "../components/post-content.vue";

const post = {
    el: '#app',
    name: 'Post',
    data() {
        return _.merge({
            sections: [],
            active: this.$session.get('post.edit.tab.active', 0),
        }, window.$data);
    },

    created() {
        const sections = [];
        _.forIn(this.$options.components, (component, name) => {
            if (component.section) {
                sections.push(_.extend({ name, priority: 0 }, component.section));
            }
        });
        this.$set(this, 'sections', _.sortBy(sections, 'priority'));
    },

    mounted() {
        const vm = this;
        this.tab = UIkit.tab('#tab', { connect: '#content' });

        UIkit.util.on(this.tab.connects, 'show', (e, tab) => {
            if (tab != vm.tab) return;
            for (const index in tab.toggles) {
                if (tab.toggles[index].classList.contains('uk-active')) {
                    vm.$session.set('post.edit.tab.active', index);
                    vm.active = index;
                    break;
                }
            }
        });
        this.tab.show(this.active);
    },

    methods: {
        submit() {
            this.$http.post('admin/api/post/save', {
                id: this.post.id,
                data: this.post,
            }).then((res) => {
                const response = res.data;
                if (!this.post.id) {
                    window.history.replaceState({}, '', this.$url.route('admin/post/edit', { id: response.query.id, type: response.query.type }));
                }
                this.$set(this, 'post', response.query);
                this.$notify(this.$trans('Saved'));
            }).catch((err) => {
                this.$notify(err.data, 'danger');
            });
        },
    },

    components: {
        Section
    },
};

export default post;

window.Post = post;

Vue.ready(window.Post);
