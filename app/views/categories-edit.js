/* eslint-disable no-restricted-syntax */
import Section from "../components/categories-content.vue";

const categories = {
    el: '#app',
    name: 'CategoriesEdit',
    data() {
        return _.merge({
            sections: [],
            active: this.$session.get('categories.edit.tab.active', 0),
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
                    vm.$session.set('categories.edit.tab.active', index);
                    vm.active = index;
                    break;
                }
            }
        });
        this.tab.show(this.active);
    },

    methods: {
        submit() {
            this.$http.post('admin/api/blog/category', {
                id: this.category.id,
                data: this.category,
            }).then((res) => {
                const response = res.data;
                if (!this.category.id) {
                    window.history.replaceState({}, '', this.$url.route('admin/blog/categories/edit', { id: response.category.id, type: response.category.type }));
                }
                this.$set(this, 'category', response.category);
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

export default categories;

window.Categories = categories;

Vue.ready(window.Categories);