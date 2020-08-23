<!--
  Product Edit
  This component is responsible for displaying the product edit page.
 -->
<script>
    export default {
        data() {
            return {
                status: 'Publish',
                title: '',
                loaded: false,
                countries: [],
                selected: [],
                article: {},
                keywords: '',
                Publish:{},
                Unpublish:{}
            }
        },
        props: {
            id: {
                type: String,
                required: true
            }
        },
        created() {
            this.load(this.id);
            this.countryCache = [];
        },
        mounted() {
            CandyEvent.$on('article-updated', event => {
                this.loaded = false;
                this.load(this.id);
            });

            this.Publish.save = ()=>{
                this.article.is_published = true;
                this.status = "Unpublish";
                CandyEvent.$emit('title-changed', {
                        title: this.article.title,
                        status: this.status
                    });
                this.save();
            }
            this.Unpublish.save = ()=>{
                this.article.is_published = false;
                this.status = "Publish";
                CandyEvent.$emit('title-changed', {
                        title: this.article.title,
                        status: this.status
                });
                this.save();
            }
            Dispatcher.add('save', this);
            Dispatcher.add('Publish', this.Publish);
            Dispatcher.add('Unpublish', this.Unpublish);
        },
        methods: {
            save() {
                var tags = [];
                var temp = this.article;
                for(let i=0;i<temp.tags.length;i++){
                    if(temp.tags[i].name && temp.tags[i].name!="")
                    tags.push(temp.tags[i].name)
                }

                if(tags.length>0){
                    temp.tags = tags.toString();
                }
                
                delete temp.assets;
                apiRequest.send('PUT', '/articles/' + temp.id, temp).then(response => {
                    CandyEvent.$emit('notification', {
                        level: 'success'
                    });
                }).catch(response => {
                    CandyEvent.$emit('notification', {
                        level: 'error',
                        message: response.message
                    });
                });
            },
            /**
             * Loads the product by its encoded ID
             * @param  {String} id
             */
            load(id) {

                apiRequest.send('get', '/articles/' + id, {})
                .then(response => {
                    this.article = response;

                    if(this.article.is_published){
                        this.status="Unpublish";
                    } else {
                        this.status="Publish"
                    }

                    CandyEvent.$emit('title-changed', {
                        title: this.article.title,
                        status: this.status
                    });

                    var tags = this.article.tags.split(",");
                    var tags_data = [];
                    
                    for(let i=0;i<tags.length;i++){
                        if(tags[i]!="")
                        tags_data.push({ name : tags[i] })
                    }

                    this.article.tags = tags_data;
                    this.loaded = true;

                    CandyEvent.$emit('title-changed', {
                        title: this.article.title
                    });

                    document.title = this.article.title + ' Articles';

                }).catch(error => {
                    CandyEvent.$emit('notification', {
                        level: 'error',
                        message: error.message
                    });
                });
            }
        }
    }
</script>

<template>
    <div>
        <template v-if="loaded">
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" class="form-control" v-model="article.title">
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" class="form-control" v-model="article.slug">
                    </div>
                    <!-- <div class="form-group">
                        <label>Gambar</label>
                        <input type="text" class="form-control" v-model="article.image">
                    </div> -->
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control" v-model="article.category">
                        <option value="news">Berita</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipe</label>
                        <select class="form-control" v-model="article.type">
                        <option value="article">Artikel</option>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Konten</label>
                        <candy-textarea :id="'default-content'"
                                        :richtext="true"
                                        v-model="article.body">
                        </candy-textarea>
                    </div>
                                        <span style="border-top: 1px solid #8080806e">
                    <candy-media
                            assetable="articles"
                            :parent="article">
                    </candy-media>
                    </span>
                    <br> 
                    <div class="form-group">
                        <label>Tag</label>
                        <candy-taggable v-model="article.tags">
                        </candy-taggable>
                    </div> 
                </div>
            </div>
        </template>

        <div v-else>
            <div class="page-loading loading">
                <span><i class="fa fa-sync fa-spin fa-3x fa-fw"></i></span> <strong>Memuat</strong>
            </div>
        </div>

    </div>

</template>

<style lang="scss" scoped>
    .region {
        header {
            margin:2em 0 1em 0;
        }
        ul {
            -moz-column-count: 4;
            -moz-column-gap: 20px;
            -webkit-column-count: 4;
            -webkit-column-gap: 20px;
            column-count: 4;
            column-gap: 20px;
            list-style:none;
            padding:0;
            label {
                margin-bottom:0;
                border-bottom:1px solid rgb(224, 224, 224);
                padding:5px 0;
                &.selected {
                    border-color:rgb(104, 174, 255);
                }
                input {
                    margin-right:5px;
                }
            }
        }
    }
</style>
