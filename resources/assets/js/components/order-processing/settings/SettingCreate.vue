<script>
    export default {
        data() {
            return {
                request : apiRequest,
                create: false,
                settings: this.baseSettings()
            }
        },
        mounted() {
        },
        computed: {
            nameUrl: {
                get() {
                    return this.settings.name.slugify();
                }
            }
        },
        methods: {
            save() {
                this.request.send('post', '/sites-settings', this.settings)
                .then(response => {
                    CandyEvent.$emit('notification', {
                        level: 'success'
                    });
                    this.create = false;
                    this.settings = this.baseSettings();
                    CandyEvent.$emit('settings-added', response.data);
                }).catch(response => {
                    CandyEvent.$emit('notification', {
                        level: 'error',
                        message: 'Missing / Invalid fields'
                    });
                });
            },
            baseSettings() {
                return {
                    name: ''
                }
            }
        }
    }
</script>

<template>
    <div>
        <button class="btn btn-success" @click="create = true"><fa icon="plus" /> Tambah Pengaturan</button>
        <candy-modal title="Create Settings" v-show="create" size="modal-md" @closed="create = false">
            <div slot="body">
                <div class="form-group">
                    <label for="name">Nama Pengaturan</label>
                    <input type="text" id="name" class="form-control" v-model="settings.name">
                    <span class="text-danger" v-if="request.getError('name')" v-text="request.getError('name')"></span>
                </div>
                 <div class="form-group">
                    <label for="value">Isi</label>
                    <candy-textarea
                                        :placeholder="'Isi'" 
                                        :id="'default-content'"
                                        :richtext="true"
                                        v-model="settings.value"></candy-textarea>
                    <span class="text-danger" v-if="request.getError('value')" v-text="request.getError('value')"></span>
                </div>
                <div class="form-group">
                    <label for="url">Link URL</label>
                    <input type="text" id="url" class="form-control" v-model="settings.url">
                    <span class="text-danger" v-if="request.getError('url')" v-text="request.getError('url')"></span>
                </div>
                <div class="form-group">
                    <label for="image_url">URL Gambar</label>
                    <input type="text" id="image_url" class="form-control" v-model="settings.image_url">
                    <span class="text-danger" v-if="request.getError('image_url')" v-text="request.getError('image_url')"></span>
                </div>
            </div>
            <template slot="footer">
                <button type="button" class="btn btn-primary" @click="save">Buat Pengaturan</button>
            </template>
        </candy-modal>
    </div>
</template>
