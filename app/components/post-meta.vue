<template>

</template>

<script>

const PostMeta = {

    section: {
        label: 'Meta',
        priority: 100,
    },

    props:['post'],
};

export default PostMeta;

window.Post.components['post-meta'] = PostMeta;

</script>
