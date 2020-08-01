<script>
    export default {
        data() {
            return {
                request : apiRequest,
                create: false,
                article: this.baseArticle()
            }
        },
        mounted() {
        },
        computed: {
            titleUrl: {
                get() {
                    return this.article.title.slugify();
                }
            }
        },
        methods: {
            save() {
                console.log("setting saved");
                // this.request.send('post', '/articles', this.article)
                // .then(response => {
                //     CandyEvent.$emit('notification', {
                //         level: 'success'
                //     });
                //     this.create = false;
                //     this.article = this.baseArticle();
                //     CandyEvent.$emit('article-added', response.data);
                // }).catch(response => {
                //     CandyEvent.$emit('notification', {
                //         level: 'error',
                //         message: 'Missing / Invalid fields'
                //     });
                // });
            },
            baseArticle() {
                return {
                    title: ''
                }
            }
        }
    }
</script>

<template>
    <div>
        <button class="btn btn-success" @click="save"><fa icon="plus" /> Save Settings</button>
    </div>
</template>
