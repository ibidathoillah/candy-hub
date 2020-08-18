<script>
    export default {
        data() {
            return {
                loaded: false,
                rows: [],
                params: {
                    per_page: 50,
                    current_page: 1,
                },
                pagination: {}
            }
        },
        mounted() {
            this.load();
            CandyEvent.$on('setting-added', product => {
                this.load();
            });
        },
        methods: {
            load() {
                apiRequest.send('get', '/sites-settings', {}, this.params)
                    .then(response => {
                        this.rows = response.data;
                        this.pagination = response.pagination;
                        this.loaded = true;
                    });
            },
            changePage(page) {
                this.loaded = false;
                this.params.current_page = page;
                this.load();
            },
            goTo: function (id) {
                location.href = route('hub.settings.edit', id);
            },
        }
    }
</script>

<template>
    <div>

        <!-- Tab panes -->
        <div class="tab-content section block">
            <div role="tabpanel" class="tab-pane active" id="all-setting">
                <table class="table table-striped collection-table">
                    <thead>
                        <tr>
                            <th>Nama Pengaturan</th>
                        </tr>
                    </thead>
                    <tbody v-if="loaded">
                        <tr class="clickable" v-for="row in rows">
                            <td @click="goTo(row.id)">
                                {{ row.name }}
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
                    <candy-table-paginate :pagination="pagination" @change="changePage"></candy-table-paginate>
                </div>
            </div>

        </div>
    </div>
</template>
