<template>
    <span>
        <button class="btn btn-primary" @click="show = true">Tambah Note</button>
        <candy-modal title="Tambah order note" v-show="show" size="modal" @closed="reset">
            <div slot="body" class="text-left">
                <div class="form-group">
                    <label>Tampilkan</label>
                    <select class="form-control" v-model="isPublic">
                        <option :value="true">Secara Publik</option>
                        <option :value="false">Secara Private</option>
                    </select>

                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea v-model="message" class="form-control" rows="8"></textarea>
                </div>

                <div class="alert alert-info" v-if="isPublic">
                    Akan tampil kepada pelanggan
                </div>
                <div class="alert alert-info" v-else>
                    Hanya dalam dashboard
                </div>

            </div>
            <template slot="footer">
                <button type="button" class="btn btn-primary" :disabled="saving" @click="save">
                    <template v-if="!saving">
                        Save note
                    </template>
                    <template v-else>
                        <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> Saving
                    </template>
                </button>
            </template>
        </candy-modal>
    </span>
</template>

<script>
    export default {
        props: {
            id: {
                required: true,
            }
        },
        data() {
            return {
                saving: false,
                show: false,
                message: null,
                isPublic: false,
            }
        },
        methods: {
            reset() {
                this.show = false;
                this.message = null;
                this.isPublic = false;
            },
            save() {
                this.saving = true;
                apiRequest.send('POST', '/activity-log', {
                    properties: {
                        message: this.message,
                    },
                    action: 'note',
                    type: 'order',
                    log: this.isPublic ? 'public' : 'private',
                    id: this.id,
                }).then(response => {
                    this.reset();
                    this.saving = false;
                    CandyEvent.$emit('log-updated');
                    CandyEvent.$emit('notification', {
                        level: 'success',
                        message: 'Note added',
                    });
                });
            }
        }
    }
</script>

<style scoped>

</style>