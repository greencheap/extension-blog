<template>
    <div class="uk-grid-small" uk-grid>
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
                    <v-editor v-model="post.content" :options="{markdown : post.data.markdown , height: 400}" />
                </div>
            </div>
        </div>
        <div class="uk-width-medium@m">
            <div class="uk-margin">
                <label for="form-image" class="uk-form-label">{{ 'Image' | trans }}</label>
                <div class="uk-form-controls">
                    <input-image-meta v-model="post.data.image" :image.sync="post.data.image" class="pk-image-max-height" />
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
            
            <categories-selector :type="type" v-model="post.categories_id"></categories-selector>

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
                        <label><input v-model="post.comment_status" class="uk-checkbox" type="checkbox" value="1"><span class="uk-margin-small-left">{{ 'Enable Comments' | trans }}</span></label>
                    </p>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import CategoriesSelector from '../../../../../app/system/modules/categories/app/components/categories-selector.vue'
export default {
    props:['post' , 'data'],

    section: {
        lable: 'Settings',
        priority: 0
    },

    data(){
        return {
            type: 'blog'
        }
    },

    components: {
        CategoriesSelector
    }
}
</script>