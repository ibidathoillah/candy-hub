<script>
    export default {
        data() {
            return {
                loaded: false,
                loaded2: false,
                customers: [],
                rows:[],
                pagination2: {},
                keywords: null,
                params: {
                    per_page: 50,
                    page: 1,
                    includes: 'groups,details'
                },
                params2: {
                    per_page: 50,
                    page: 1,
                },
                pagination: {}
            }
        },

        mounted() {
            this.loadCustomers();
            this.loadCustomers2();
        },
        methods: {
            del(row){
                apiRequest.send('delete', '/subscribe/'+ row.id, {})
                    .then(response => {
                        this.loadCustomers2();
                    });
            },
            loadCustomers() {
                apiRequest.send('get', '/customers', [], this.params)
                    .then(response => {
                        this.customers = response.data;
                        this.pagination = response.meta.pagination;
                        this.loaded = true;
                    });
            },
            loadCustomers2() {
                apiRequest.send('get', '/subscribe', this.params2)
                    .then(response => {
                        this.rows = response.data;
                        this.pagination2 = response;
                        this.loaded2 = true;
                    });
            },
            details(customer) {
                return customer.details.data;
            },
            changePage(page) {
                this.loaded = false;
                this.params.page = page;
                this.loadCustomers();
            },
            changePage2(page) {
                this.loaded2 = false;
                this.params2.page = page;
                this.loadCustomers2();
            },
            loadCustomer: function (id) {
                location.href = route('hub.customers.edit', id);
            },
            search: _.debounce(function (){
                    this.loaded = false;
                    this.params['keywords'] = this.keywords;
                    this.params['page'] = 1;
                    this.loadCustomers();
                }, 500
            ),
        }
    }
</script>

<template>
    <div>

        <!-- Search tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#all-customers" aria-controls="all-customers" role="tab" data-toggle="tab">
                    Semua Pelanggan
                </a>
            </li>
            <li role="presentation">
               <a href="#all-subscribers" aria-controls="all-subscribers" role="tab" data-toggle="tab">
                    Subscribers
                </a>
            </li>

        </ul>
        <!-- Tab panes -->
        <div class="tab-content section block">
            <div role="tabpanel" class="tab-pane active" id="all-customers">

                <!-- Search Form -->
                <form>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="input-group input-group-full">
                                <span class="input-group-addon">
                                  <i class="fa fa-search" aria-hidden="true"></i>
                                </span>
                                <label class="sr-only" for="search">Cari</label>
                                <input type="text" class="form-control" id="search" placeholder="Search" @keyup="search" v-model="keywords">
                            </div>
                        </div>
                    </div>
                </form>
                <table class="table table-striped collection-table">
                    <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th width="10%">Nama Pelanggan</th>
                            <th width="19%">Nama Perusahaan</th>
                            <th width="19%">Email</th>
                            <th>Grup Pelanggan</th>
                        </tr>
                    </thead>
                    <tbody v-if="loaded">
                        <tr class="clickable" v-for="customer in customers">
                            <td @click="loadCustomer(customer.id)">{{ customer.id }}</td>
                            <td @click="loadCustomer(customer.id)">
                                <template v-if="details(customer).firstname">
                                    {{ details(customer).firstname }} {{ details(customer).lastname }}
                                </template>
                                <span v-else>{{ customer.name }}</span>
                            </td>
                            <td @click="loadCustomer(customer.id)">
                                <span v-if="details(customer).company_name">{{ details(customer).company_name }}</span>
                                <span v-else class="text-muted"><small>-</small></span>
                            </td>
                            <td @click="loadCustomer(customer.id)">{{ customer.email }}</td>
                            <td @click="loadCustomer(customer.id)">
                                <span v-for="group, index in customer.groups.data">{{ group.name }}<span v-if="index + 1 != customer.groups.data.length" class="text-muted">&nbsp;&middot;&nbsp;</span></span>
                            </td>
                        </tr>


                    </tbody>
                    <tfoot class="text-center" v-else>
                        <tr>
                            <td colspan="25" style="padding:40px;">
                                <div class="loading">
                                    <span><i class="fa fa-sync fa-spin fa-3x fa-fw"></i></span> <strong>Memuat</strong>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <div class="text-center">
                    <candy-table-paginate :total="pagination.total_pages" :current="pagination.current_page" @change="changePage"></candy-table-paginate>
                </div>
            </div>
             <div role="tabpanel" class="tab-pane" id="all-subscribers">
                <table class="table table-striped collection-table">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Aktivasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody v-if="loaded2">
                        <tr class="clickable" v-for="row in rows">
                            <td >
                                {{ row.email }}
                            </td>
                            <td >
                                {{ row.isActive ? "Teraktivasi" : "Menunggu Persetujuan" }}
                            </td>
                            <td >
                                <button @click="del(row)" class="btn btn-primary">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="text-center" v-else>
                        <tr>
                            <td colspan="25" style="padding:40px;">
                                <div class="loading">
                                    <span><fa icon="spinner" size="3x" spin /></span> <strong>Memuat</strong>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <div class="text-center">
                    <candy-table-paginate :current="params2.page" :total="pagination2.last_page" @change="changePage2"></candy-table-paginate>
                </div>
             </div>

        </div>
    </div>
</template>