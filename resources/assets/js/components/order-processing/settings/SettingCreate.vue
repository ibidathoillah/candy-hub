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
                this.request.send('post', '/articles', this.article)
                .then(response => {
                    CandyEvent.$emit('notification', {
                        level: 'success'
                    });
                    this.create = false;
                    this.article = this.baseArticle();
                    CandyEvent.$emit('article-added', response.data);
                }).catch(response => {
                    CandyEvent.$emit('notification', {
                        level: 'error',
                        message: 'Missing / Invalid fields'
                    });
                });
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
        <button class="btn btn-success" @click="create = true"><fa icon="plus" /> Add Article</button>
        <candy-modal title="Create Article" v-show="create" size="modal-md" @closed="create = false">
            <div slot="body">
                <div class="form-group">
                    <label for="title">Enter the title article.</label>
                    <input type="text" id="title" class="form-control" v-model="article.title">
                    <span class="text-info" v-if="article.title">Your url will be sanitized to: <code>{{ titleUrl }}</code></span>
                    <span class="text-danger" v-if="request.getError('title')" v-text="request.getError('title')"></span>
                </div>
            </div>
            <template slot="footer">
                <button type="button" class="btn btn-primary" @click="save">Create article</button>
            </template>
        </candy-modal>
    </div>
</template>
