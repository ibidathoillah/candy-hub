<!--
  Product Edit
  This component is responsible for displaying the product edit page.
 -->
<script>
    export default {
        data() {
            return {
                title: '',
                loaded: false,
                selected: [],
                settings: {},
                currentSub: {},
                keywords: '',
                showSub: false,
                request : apiRequest,
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
            CandyEvent.$on('settings-updated', event => {
                this.loaded = false;
                this.load(this.id);
            });
            CandyEvent.$on('settings-added', event => {
                this.loaded = false;
                this.load(this.id);
            });
            

            Dispatcher.add('save-settings', this);
        },
        methods: {
            desc(e) {
                console.log("saved settings", e)
                $($(e).next()[0]).show('slow')
            },
            save() {
                console.log("saved settings")
            },
            /**
             * Loads the product by its encoded ID
             * @param  {String} id
             */
            load(id) {
                this.request.send('get', '/settings/', {})
                .then(response => {

                    this.settings = response;
                    this.loaded = true;
 
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
             <v-style>
                .trumbowyg-box {
                    display:none;
                }
            </v-style>
            <div class="panel">
                <div class="panel-body">
                    <h4>{{ JSON.stringify(settings) }}</h4>
                    <div v-for="set in settings" style="margin-bottom: 50px;">
                        <div class="form-group" >
                            <input type="text" class="form-control" placeholder="Nama" v-model="set.name">
                             <a href="#" @click="desc($event)">Tambah Deskripsi</a>
                             <candy-textarea
                                        :placeholder="'Isi'" 
                                        :id="'default-content'"
                                        :richtext="true"
                                        v-model="set.value">
                            </candy-textarea>
                            <input type="text" class="form-control" :placeholder="'Link '" v-model="set.url">
                            <input type="text" class="form-control" :placeholder="'URL Gambar '"  v-model="set.image_url">
                            <div style="padding: 20px;padding-top:5px;zoom: 0.7;">
                            <button class="btn btn-success" style="float:right;margin-bottom:10px" @click="showSub = true">Tambah Detail</button>
                            

                                    <candy-modal :title="'Buat Sub Pengaturan'"  v-show="showSub" size="modal-md" @closed="showSub = false">
                                        <div slot="body">
                                            <div class="form-group">
                                                <label for="title">Enter the title sub.</label>
                                                <input type="text" id="title" class="form-control" v-model="currentSub.title">
                                                <span class="text-danger" v-if="request.getError('title')" v-text="request.getError('title')"></span>
                                            </div>
                                        </div>
                                        <template slot="footer">
                                            <button type="button" class="btn btn-primary" @click="save">Create sub</button>
                                        </template>
                                    </candy-modal>


                            <div style="margin-bottom:5px" v-if="set.sub_settings" v-for="set2 in set.sub_settings">

                            <input type="text" class="form-control" placeholder="Nama" v-model="set2.name">
                            <a href="#" @click="desc($event)">Tambah Deskripsi</a>
                            <candy-textarea
                                        :placeholder="'Isi'" 
                                        :id="'default-content'"
                                        :richtext="true"
                                        v-model="set2.value">
                            </candy-textarea>
                            <input type="text" class="form-control" :placeholder="'Link '" v-model="set2.url">
                            <input type="text" class="form-control" :placeholder="'URL Gambar '"  v-model="set2.image_url">
                                <button class="btn btn-warning" style="float:right">Hapus</button>
                            </div>
                            </div>
                        </div>
                        <button class="btn btn-danger">Hapus</button>
                    </div>
                    <!-- <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="article.title">
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" class="form-control" v-model="article.slug">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Content</label>
                        <candy-textarea :id="'default-content'"
                                        :richtext="true"
                                        v-model="article.body">
                        </candy-textarea>
                    </div> 
                                    <div class="form-group">
                        <label>Tag</label>
                        <candy-taggable v-model="article.tags">
                        </candy-taggable>
                    </div>  -->
                </div>
            </div>
        </template>

        <div v-else>
            <div class="page-loading loading">
                <span><i class="fa fa-sync fa-spin fa-3x fa-fw"></i></span> <strong>Loading</strong>
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
