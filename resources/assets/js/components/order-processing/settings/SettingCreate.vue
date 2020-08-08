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
            titleUrl: {
                get() {
                    return this.settings.title.slugify();
                }
            }
        },
        methods: {
            save() {
                this.request.send('post', '/settings', this.settings)
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
                    title: ''
                }
            }
        }
    }
</script>

<template>
    <div>
        <button class="btn btn-success" @click="create = true"><fa icon="plus" /> Add Settings</button>
        <candy-modal title="Create Settings" v-show="create" size="modal-md" @closed="create = false">
            <div slot="body">
                <div class="form-group">
                    <label for="title">Enter the settings.</label>
                    <input type="text" id="title" class="form-control" v-model="settings.title">
                    <span class="text-info" v-if="settings.title">Your url will be sanitized to: <code>{{ titleUrl }}</code></span>
                    <span class="text-danger" v-if="request.getError('title')" v-text="request.getError('title')"></span>
                </div>
            </div>
            <template slot="footer">
                <button type="button" class="btn btn-primary" @click="save">Create Settings</button>
            </template>
        </candy-modal>
    </div>
</template>
