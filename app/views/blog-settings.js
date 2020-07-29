var Settings = {
    el: '#settings',
    data() {
        return window.$data;
    },

    methods: {

        save() {
            this.$http.post('admin/system/settings/config', { name: 'blog', config: this.config }).then(function () {
                this.$notify('Settings saved.');
            }, function (res) {
                this.$notify(res.data, 'danger');
            });
        },

    },

};

export default Settings;

Vue.ready(Settings);
