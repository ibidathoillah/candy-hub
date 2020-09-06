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
                apiRequest.send('get', '/articles?draft=1', {}, this.params)
                    .then(response => {
                        this.rows = response.data;
                        this.pagination = response;
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
        }
    }
</script>

<template>
    <div>

        <!-- Tab panes -->
        <div class="tab-content section block">
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
            <div role="tabpanel" class="tab-pane active" id="all-article">
                <table class="table table-striped collection-table">
                    <thead>
                        <tr>
                            <th style="width: 300px;">Title</th>
                            <th style="width: 100px;">Kategori</th>
                            <th style="width: 100px;">Slug</th>
                            <th style="width: 100px;">Type</th>
                            <th style="width: 100px;">Tags</th>
                            <th style="width: 80px;">Status</th>
                            <th>Content</th>
                        </tr>
                    </thead>
                    <tbody v-if="loaded">
                        <tr class="clickable" v-for="row in rows">
                            <td @click="goTo(row.id)">
                                {{ row.title }}
                            </td>
                            <td @click="goTo(row.id)">
                                {{ row.category ?  row.category.name  : "" }}
                            </td>
                            <td @click="goTo(row.id)">
                                <a href="#">{{ row.slug }}</a>
                            </td>
                            <td @click="goTo(row.id)">
                                <a href="#">{{ row.type  ?  row.type.name  : ""  }}</a>
                            </td>
                            <td @click="goTo(row.id)">
                                <a href="#">{{ row.tags.toString() }}</a>
                            </td>
                            <td @click="goTo(row.id)">
                                <i>{{ row.is_published ? "Published": "Draft" }}</i>
                            </td>
                            <td @click="goTo(row.id)">
                                {{ row.content ? row.content.substring(0,200) + "..."  : ""  }}
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
