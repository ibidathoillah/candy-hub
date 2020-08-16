<script>
    export default {
        data() {
            return {
                modal: false,
                name: null,
            }
        },
        mounted() {
        },
        methods: {
            save() {
                apiRequest.send('POST', '/product-families', {
                    name: {
                        [locale.current()] : this.name,
                    }
                })
                    .then(response => {
                        this.name = null;
                        this.modal = false;
                        CandyEvent.$emit('product-family-added', response.data);
                    });
            }
        }
    }
</script>

<template>
    <div>
        <button class="btn btn-success" @click="modal = true"><fa icon="plus" class="fa-first"></fa> Buat Brands</button>
        <candy-modal title="Create Brands" v-show="modal" size="modal-md" @closed="modal = false">
            <div slot="body">
                <div class="form-group">
                    <label>Nama</label>
                    <input class="form-control" v-model="name">
                </div>
            </div>
            <template slot="footer">
                <button type="button" class="btn btn-primary" @click="save">Simpan</button>
            </template>
        </candy-modal>
    </div>
</template>