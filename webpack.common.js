const VueLoaderPlugin = require('vue-loader/lib/plugin');
const path = require('path');

module.exports = {
    entry: {
        'post-index': './app/views/post-index',
        'post-edit': './app/views/post-edit',
        'categories-index': './app/views/categories-index',
        'categories-edit': './app/views/categories-edit',
        'blog-settings': './app/views/blog-settings',
        'post': './app/views/post',
        'link-blog': './app/components/link-blog.vue',
        'post-meta': './app/components/post-meta.vue'

    },
    output: {
        path: path.resolve(__dirname, './app/bundle'),
        filename: '[name].js'
    },
    module: {
        rules: [{
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.js$/,
                loader: 'babel-loader'
            },
            {
                test: /\.css$/,
                use: [
                    'vue-style-loader',
                    'css-loader',
                ]
            }
        ]
    },
    plugins: [
        new VueLoaderPlugin()
    ]
};