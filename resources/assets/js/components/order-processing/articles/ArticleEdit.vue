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
                categories: [],
                types: [],
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
            broadcast(){
                if(window.confirm("Apakah anda yakin ini membroadcast "+this.article.title +"?")){
                    apiRequest.send('POST', '/articles/' + this.article.id +'/broadcast', {}).then(response => {
                        CandyEvent.$emit('notification', {
                            level: 'success',
                            message: "Broadcast berhasil dikirim"
                        });
                    }).catch(response => {
                        CandyEvent.$emit('notification', {
                            level: 'error',
                            message: response.message
                        });
                    });
                }
            },
            addCategory(slug){
                if(slug=="addNew"){
                    
                    let name = window.prompt("Masukkan nama kategori");

                    apiRequest.send('POST', '/article-categories', {
                        name : name,
                        slug : name
                    }).then(response => {
                        CandyEvent.$emit('notification', {
                            level: 'success'
                        });
                    }).catch(response => {
                        CandyEvent.$emit('notification', {
                            level: 'error',
                            message: response.message
                        });
                    });
                }else {

                }


                apiRequest.send('get', '/article-categories', {})
                 .then(response => {
                     this.categories= response;
                 });


                
            },
            addType(slug){
                if(slug=="addNew"){
                    
                    let name = window.prompt("Masukkan nama kategori");

                    apiRequest.send('POST', '/article-types', {
                        name : name,
                        slug : name
                    }).then(response => {
                        CandyEvent.$emit('notification', {
                            level: 'success'
                        });
                    }).catch(response => {
                        CandyEvent.$emit('notification', {
                            level: 'error',
                            message: response.message
                        });
                    });
                }else {

                }


                 apiRequest.send('get', '/article-types', {})
                 .then(response => {
                     this.types= response;
                 });
                

            },
            deleteArticle(){

                if(window.confirm("Hapus artikel "+this.article.title+" ?")){

                    apiRequest.send('DELETE', '/articles/' + this.article.id, {}).then(response => {
                        CandyEvent.$emit('notification', {
                            level: 'success'
                        });
                    }).catch(response => {
                        CandyEvent.$emit('notification', {
                            level: 'error',
                            message: response.message
                        });
                    });
                }
            },
            save() {
                var tags = [];
                var temp = {...this.article};
                for(let i=0;i<temp.tags.length;i++){
                    if(temp.tags[i].name && temp.tags[i].name!="")
                    tags.push(temp.tags[i].name)
                }

                if(tags.length>0){
                    temp.tags = tags.toString();
                }else {
                    temp.tags = "";
                }
                
                delete temp.assets;
                delete temp.user;
                delete temp.others;
                temp.category=temp.category.slug;
                temp.type=temp.type.slug;
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

                apiRequest.send('get', '/article-categories', {})
                 .then(response => {
                     this.categories= response;
                 });

                 apiRequest.send('get', '/article-types', {})
                 .then(response => {
                     this.types= response;
                 });

                apiRequest.send('get', '/articles/' + id, {})
                .then(response => {
                    this.article = response;

                    if(!this.article.category){
                        this.article.category = {
                            slug : null
                        }
                    }

                     if(!this.article.type){
                        this.article.type = {
                            slug : null
                        }
                    }

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
                        <select class="form-control" v-model="article.category.slug" @change="addCategory(article.category.slug)" >
                        <option v-for="option in categories" v-bind:value="option.slug">{{option.name}}</option>
                        <option value="addNew">Tambah Baru</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipe</label>
                        <select class="form-control" v-model="article.type.slug" @change="addType(article.type.slug)">
                            <option v-for="option in types" v-bind:value="option.slug">{{option.name}}</option>
                             <option value="addNew">Tambah Baru</option>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Konten</label>
                        <candy-textarea :id="'default-content'"
                                        :richtext="true"
                                        v-model="article.content">
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
                    <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary" @click="broadcast"><i class="fa fa-check"></i> Broadcast
                                </button>
                            </div>
                    </div>
                    <br/>
                     <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-danger" @click="deleteArticle"><i class="fa fa-trash"></i> Hapus Artikel
                                </button>
                            </div>
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
