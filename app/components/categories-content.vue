<template>
    <div>
        <div uk-grid>
            <div class="uk-width-expand@s">
                <div class="uk-margin">
                    <label class="uk-form-label">{{'Title' | trans}}</label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-large uk-width-expand" type="text" v-model="category.title" required>
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label">{{ 'Excerpt' | trans }}</label>
                    <div class="uk-form-controls">
                        <v-editor v-model="category.excerpt" :options="{markdown : category.data.markdown , height: 300}" />
                    </div>
                </div>
            </div>

            <div class="uk-width-medium@s">
                <div class="uk-margin">
                    <label class="uk-form-label">{{ 'Status' | trans }}</label>
                    <div class="uk-form-controls">
                        <select v-model="category.status" class="uk-select uk-width-expand">
                            <option v-for="(status , id) in data.statuses" :key="id" :value="id">
                                {{ status }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label">{{ 'Slug' | trans }}</label>
                    <div class="uk-form-controls">
                        <input v-model="category.slug" type="text" class="uk-input uk-width-expand">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label">{{ 'Publish on' | trans }}</label>
                    <div class="uk-form-controls">
                        <input-date v-model="category.date" />
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label">{{ 'User' | trans }}</label>
                    <div class="uk-form-controls">
                        <select v-model="category.user_id" class="uk-select uk-width-expand">
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
                            <label><input v-model="category.roles" class="uk-checkbox" type="checkbox" :value="role.id" number><span class="uk-margin-small-left">{{ role.name }}</span></label>
                        </p>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label">{{ 'Options' | trans }}</label>
                    <div class="uk-form-controls uk-form-controls-text">
                        <p class="uk-margin-small">
                            <label><input v-model="category.data.markdown" class="uk-checkbox" type="checkbox" value="1"><span class="uk-margin-small-left">{{ 'Enable Markdown' | trans }}</span></label>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['category', 'data'],

        section:{
            label: 'Settings',
            priorty:0
        }
    }
</script>