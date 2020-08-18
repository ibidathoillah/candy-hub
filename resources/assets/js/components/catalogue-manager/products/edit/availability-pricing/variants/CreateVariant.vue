<script>
    export default {
        data() {
            return {
                locale: locale.current(),
                modalOpen: false,
                options: [],
                variant: {
                    options: {},
                    sku: '',
                    price: '',
                    inventory: 1
                }
            }
        },
        props: {
            product: {
                type: Object
            },
            showModal: {
                type: Boolean,
                default: false
            }
        },
        created() {
            this.modalOpen = this.showModal;
        },
        mounted() {
            Object.keys(this.product.option_data).map(key => {
                this.product.option_data[key].handle = key;
                this.options.push(this.product.option_data[key]);
            });
            this.options.forEach(option => {
                this.$set(this.variant.options, option.handle, {[locale.current()] : ''});
            });
        },
        methods: {
            save() {
                apiRequest.send('post', '/products/' + this.product.id + '/variants', {variants: [this.variant]})
                    .then(response => {
                        CandyEvent.$emit('notification', {
                            level: 'success'
                        });
                        CandyEvent.$emit('product-updated', {
                            variants: this.variants
                        });
                        this.modalOpen = false;
                    }).catch(response => {
                        CandyEvent.$emit('notification', {
                            level: 'error',
                            message: 'Ada field yang belum diisi'
                        });
                    });
            }
        }
    }
</script>

<template>
    <div>
        <button class="btn btn-primary" @click="modalOpen = true">Buat variant</button>
        <candy-modal title="Buat variant" v-show="modalOpen" @closed="modalOpen = false">
            <div slot="body" class="text-left">
                <div class="row">
                    <div class="col-md-6" v-for="(option, handle) in options">
                        <div class="form-group">
                            <label :for="option.label|t">
                                {{ option.label|t }}
                            </label>
                            <input type="text" class="form-control" v-model="variant.options[option.handle][locale]">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <label for="sku">SKU</label>
                        <input type="text" class="form-control" v-model="variant.sku">
                    </div>
                    <div class="col-md-4">
                        <label for="sku">Harga</label>
                        <div class="input-group input-group-full">
                            <span class="input-group-addon">IDR</span>
                            <input type="number" class="form-control" v-model="variant.price">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="sku">Inventory</label>
                        <input type="text" class="form-control" v-model="variant.inventory">
                    </div>
                </div>

            </div>
            <template slot="footer">
                <button class="btn btn-primary" @click="save()">Simpan Variant</button>
            </template>
        </candy-modal>
    </div>
</template>
