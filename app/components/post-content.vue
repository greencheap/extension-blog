<template>
    <div uk-grid>
        <div class="uk-width-expand@m">
            <div class="uk-margin">
                <label class="uk-form-label">{{'Title' | trans}}</label>
                <div class="uk-form-controls">
                    <input class="uk-input uk-form-large uk-width-expand" type="text" v-model="post.title" required>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label">{{ 'Excerpt' | trans }}</label>
                <div class="uk-form-controls">
                    <v-editor v-model="post.excerpt" :options="{markdown : post.data.markdown , height: 100}" />
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label">{{ 'Content' | trans }}</label>
                <div class="uk-form-controls">
                    <v-editor v-model="post.content" :options="{markdown : post.data.markdown , height: 700}" />
                </div>
            </div>
        </div>
        <div class="uk-width-medium@m">
            <div class="uk-margin" style="display:none">
                <label class="uk-form-label">{{ 'Type' | trans }}</label>
                <div class="uk-form-controls">
                    <p v-for="(type , id) in getTypes" class="uk-margin-small" :key="id">
                        <label><input type="radio" class="uk-radio uk-margin-small-right" :value="type.type" v-model="post.data.type"> <i :uk-icon="type.icon"></i> {{type.text}}</label>
                    </p>
                </div>
            </div>

            <div class="uk-margin">
                <label for="form-image" class="uk-form-label">{{ 'Image' | trans }}</label>
                <div class="uk-form-controls">
                    <v-multi-finder v-model="post.data.image" :image.sync="post.data.image" class="pk-image-max-height" />
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label">{{ 'Status' | trans }}</label>
                <div class="uk-form-controls">
                    <select v-model="post.status" class="uk-select uk-width-expand">
                        <option v-for="(status , id) in data.statuses" :key="id" :value="id">
                            {{ status }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label">{{ 'Slug' | trans }}</label>
                <div class="uk-form-controls">
                    <input v-model="post.slug" type="text" class="uk-input uk-width-expand">
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label">{{ 'Categories' | trans }}</label>
                <div class="uk-form-controls">
                    <p v-for="category in data.categories" class="uk-margin-small" :key="category.id">
                        <label><input v-model="post.categories_id" class="uk-checkbox" type="checkbox" :value="category.id" number><span class="uk-margin-small-left">{{ category.title }}</span></label>
                    </p>
                </div>
                <div v-if="!data.categories.length || !data.categories" class="uk-padding-small uk-text-center">
                    <span>{{"No attached category found, please add a category first." | trans}}</span>
                    <a :href="$url('admin/blog/categories/edit')">{{"Add a new category" | trans}}</a>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label">{{ 'Publish on' | trans }}</label>
                <div class="uk-form-controls">
                    <input-date v-model="post.date" />
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label">{{ 'User' | trans }}</label>
                <div class="uk-form-controls">
                    <select v-model="post.user_id" class="uk-select uk-width-expand">
                        <option v-for="user in data.users" :key="user.id" :value="user.id">
                            {{ user.name }} - {{ user.username }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label">{{ 'Restrict Access' | trans }}</label>
                <div class="uk-form-controls uk-form-controls-text">
                    <p v-for="role in data.roles" class="uk-margin-small" :key="role.id">
                        <label><input v-model="post.roles" class="uk-checkbox" type="checkbox" :value="role.id" number><span class="uk-margin-small-left">{{ role.name }}</span></label>
                    </p>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label">{{ 'Options' | trans }}</label>
                <div class="uk-form-controls uk-form-controls-text">
                    <p class="uk-margin-small">
                        <label><input v-model="post.data.markdown" class="uk-checkbox" type="checkbox" value="1"><span class="uk-margin-small-left">{{ 'Enable Markdown' | trans }}</span></label>
                    </p>
                    <p class="uk-margin-small">
                        <label><input v-model="post.data.comment_status" class="uk-checkbox" type="checkbox" value="1"><span class="uk-margin-small-left">{{ 'Enable Comments' | trans }}</span></label>
                    </p>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    props:['post' , 'data'],

    section: {
        label: 'Settings',
        priority: 0
    },

    computed:{
        getTypes(){
            return [
                {
                    'icon': 'file-text',
                    'text': 'Article Content',
                    'type': 'article'
                },
                {
                    'icon': 'play-circle',
                    'text': 'Video Content',
                    'type': 'video'
                },
                
                {
                    'icon': 'album',
                    'text': 'Gallery Content',
                    'type': 'gallery'
                }
            ]
        }
    }
}
</script>