<script>
    export default {
        data() {
            return {
                request : apiRequest,
                create: false,
                method: this.baseMethod(),
                channel: this.$store.getters.getDefaultChannel.handle
            }
        },
        mounted() {
        },
        computed: {
            name: {
                get() {
                    return this.method.name[locale.current()];
                },
                set(value) {
                    this.method.name[locale.current()] = value;
                }
            }
        },
        methods: {
            save() {
                this.request.send('post', '/shipping', this.method)
                .then(response => {
                    CandyEvent.$emit('notification', {
                        level: 'success'
                    });
                    this.create = false;
                    this.method = this.baseMethod();
                    CandyEvent.$emit('shipping-method-added', response.data);
                }).catch(response => {
                    CandyEvent.$emit('notification', {
                        level: 'error',
                        message: 'Ada field yang belum diisi'
                    });
                });
            },
            baseMethod() {
                return {
                    name: {
                        [locale.current()] : ''
                    },
                    type: 'standard'
                }
            }
        }
    }
</script>

<template>
    <div>
        <button class="btn btn-success" @click="create = true"><fa icon="plus" /> Tambah Shipping Method</button>
        <candy-modal title="Buat Shipping Method" v-show="create" size="modal-md" @closed="create = false">
            <div slot="body">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" v-model="name" @input="request.clearError('name')">
                    <span class="text-danger" v-if="request.getError('name')" v-text="request.getError('name')"></span>
                </div>
                <div class="form-group">
                    <label for="type">Tipe</label>
                    <select class="selectpicker" v-model="method.type">
                        <option value="standard">Standard</option>
                        <option value="regional">Regional</option>
                        <!-- <option value="dhl" disabled>DHL</option> -->
                    </select>
                </div>
            </div>
            <template slot="footer">
                <button type="button" class="btn btn-primary" @click="save">Buat method</button>
            </template>
        </candy-modal>
    </div>
</template>
