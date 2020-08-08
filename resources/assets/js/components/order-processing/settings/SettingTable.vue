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
                currentSet: {}
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
            createsub(){
                if(!this.currentSet.sub_settings){
                    this.currentSet.sub_settings = [];
                }
                var data = this.currentSub;
                this.currentSet.sub_settings.push(data);
                CandyEvent.$emit('notification', {
                        level: 'success'
                });
                this.currentSub = {};
                this.showSub = false;
            },
            del(a){
                if(window.confirm("Apakah kamu yakin untuk menghapus pengaturan" +a.name)){
                    this.request.send('delete', '/sites-settings/' + a.name)
                    .then(response => {
                        CandyEvent.$emit('notification', {
                            level: 'success'
                        });
                        this.settings = this.settings.filter(x => x.id!=a.id)

                    }).catch(response => {
                        CandyEvent.$emit('notification', {
                            level: 'error',
                            message: 'Missing / Invalid fields'
                        });
                    });
                }

            },
            del2(a,b){
                a.sub_settings = a.sub_settings.filter(x => x.name!=b.name)
            },
            desc(e) {
                var cur = $(e.target);
                var next = $(cur.next()[0]);

                if(next.is(":visible")){
                    next.hide('slow');
                    cur.text("+ Tambah Deskripsi")
                }else {
                    next.show('slow');
                    cur.text("- Tutup")
                }
                
            },
            save(data) {
                this.request.send('put', '/sites-settings/' + data.name, data)
                .then(response => {
                    CandyEvent.$emit('notification', {
                        level: 'success'
                    });
                }).catch(response => {
                    CandyEvent.$emit('notification', {
                        level: 'error',
                        message: 'Missing / Invalid fields'
                    });
                });
            },
            /**
             * Loads the product by its encoded ID
             * @param  {String} id
             */
            load(id) {
                this.request.send('get', '/sites-settings/', {})
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
            <div class="panel">
                <div class="panel-body">
                    <candy-modal :title="'Buat Sub Pengaturan [' + [currentSet.name] +']'"  v-show="showSub" size="modal-md" @closed="showSub = false">
                                        <div slot="body">
                <div class="form-group">
                    <label for="name">Nama Pengaturan</label>
                    <input type="text" id="name" class="form-control" v-model="currentSub.name">
                    <span class="text-danger" v-if="request.getError('name')" v-text="request.getError('name')"></span>
                </div>
                 <div class="form-group">
                    <label for="value">Isi</label>
                    <candy-textarea
                                        :placeholder="'Isi'" 
                                        :id="'default-content'"
                                        :richtext="true"
                                        v-model="currentSub.value"></candy-textarea>
                    <span class="text-danger" v-if="request.getError('value')" v-text="request.getError('value')"></span>
                </div>
                <div class="form-group">
                    <label for="url">Link URL</label>
                    <input type="text" id="url" class="form-control" v-model="currentSub.url">
                    <span class="text-danger" v-if="request.getError('url')" v-text="request.getError('url')"></span>
                </div>
                <div class="form-group">
                    <label for="image_url">URL Gambar</label>
                    <input type="text" id="image_url" class="form-control" v-model="currentSub.image_url">
                    <span class="text-danger" v-if="request.getError('image_url')" v-text="request.getError('image_url')"></span>
                </div>
                                        </div>
                                        <template slot="footer">
                                            <button type="button" class="btn btn-primary" @click="createsub">Tambahkan Sub Pengaturan</button>
                                        </template>
                                    </candy-modal>
                    <!-- <h4>{{ JSON.stringify(settings) }}</h4> -->
                    <div v-for="set in settings">
                         <h3>Pengaturan {{set.name}}</h3>
                        <div class="form-group" >
                            <div class="input-group input-group-full"><span class="input-group-addon">Nama</span>  <input type="text" class="form-control" placeholder="Nama" v-model="set.name"></div>
                            <div class="input-group input-group-full"><span class="input-group-addon">Link</span>  <input type="text" class="form-control" placeholder="Link" v-model="set.url"></div>
                           <div class="input-group input-group-full"><span class="input-group-addon">URL Gambar</span>  <input type="text" class="form-control" placeholder="URL Gambar" v-model="set.image_url"></div>
                            <a @click="desc($event)">+ Tambah Deskripsi</a>
                             <div style="display:none"><candy-textarea
                                        :placeholder="'Isi'" 
                                        :id="'default-content'"
                                        :richtext="true"
                                        v-model="set.value">
                            </candy-textarea></div>

                            <div style="padding: 20px;padding-top:5px;zoom: 0.7;">
                            <button class="btn btn-success" @click="showSub = true;currentSet=set">Tambah Detail</button>
                            <div style="margin-bottom:5px" v-if="set.sub_settings" v-for="set2 in set.sub_settings">
                            <label>Sub Pengaturan - {{set2.name}}</label>
                            <div class="input-group input-group-full"><span class="input-group-addon">Nama</span>  <input type="text" class="form-control" placeholder="Nama" v-model="set2.name"></div>
                            <div class="input-group input-group-full"><span class="input-group-addon">Link</span>  <input type="text" class="form-control" placeholder="Link" v-model="set2.url"></div>
                           <div class="input-group input-group-full"><span class="input-group-addon">URL Gambar</span>  <input type="text" class="form-control" placeholder="URL Gambar" v-model="set2.image_url"></div>
                             <a @click="desc($event)">+ Tambah Deskripsi</a>
                             <div style="display:none"><candy-textarea
                                        :placeholder="'Isi'" 
                                        :id="'default-content'"
                                        :richtext="true"
                                        v-model="set2.value">
                            </candy-textarea></div>
                                <button class="btn btn-warning" style="float:right" @click="del2(set,set2)">Hapus</button>
                            </div>
                            </div>
                        </div>
                        <button @click="save(set)"  class="btn btn-primary">Simpan</button> <button class="btn btn-danger"  @click="del(set)">Hapus</button>
                        <hr/>
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
