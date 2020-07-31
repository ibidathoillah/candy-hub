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
            CandyEvent.$on('article-added', product => {
                this.load();
            });
        },
        methods: {
            load() {
                apiRequest.send('get', '/articles', {}, this.params)
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
                location.href = route('hub.article.edit', id);
            },
            getRegions(zone) {
                var regions = [];

                _.each(zone.countries.data, country => {
                    if (!regions.includes(country.region)) {
                        if (!country.name) {
                            country.name = 'Rest of world';
                        }
                        regions.push(country.region);
                    }
                });

                return regions;
            }
        }
    }
</script>

<template>
    <div>

        <!-- Tab panes -->
        <div class="tab-content section block">
            <div role="tabpanel" class="tab-pane active" id="all-zones">
                <table class="table table-striped collection-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Content</th>
                        </tr>
                    </thead>
                    <tbody v-if="loaded">
                        <tr class="clickable" v-for="row in rows">
                            <td @click="goTo(row.id)">
                                {{ row.name }}
                            </td>
                            <!-- <td>
                                <span v-for="(region, index) in getRegions(row)">{{ region }}<span v-if="index < getRegions(row).length - 1">, </span></span>
                            </td>
                            <td>
                                <template v-if="row.countries.data.length > 5">
                                    {{ row.countries.data.length }} Countries
                                </template>
                                <template v-else>
                                    <span v-for="(country, index) in row.countries.data">
                                        {{ country.name }}<span v-if="index < row.countries.data.length - 1">, </span>
                                    </span>
                                </template>
                            </td> -->
                        </tr>


                    </tbody>
                    <tfoot class="text-center" v-else>
                        <tr>
                            <td colspan="25" style="padding:40px;">
                                <div class="loading">
                                    <span><fa icon="spinner" size="3x" spin /></span> <strong>Loading</strong>
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
