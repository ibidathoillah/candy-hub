<script>
    export default {
        data() {
            return {
                loaded: false,
                rows: [],
                params: {
                    per_page: 10,
                    page: 1,
                    keywords: null,
                    draft:1
                },
                pagination: {},
                keywords: "",
                highlight:null
            }
        },
        mounted() {
            this.load();
            this.loadHighlight();
            CandyEvent.$on('article-added', product => {
                this.load();
            });
        },
        methods: {
            search: _.debounce(function (){
                    this.loaded = false;
                    this.params['keywords'] = this.keywords;
                    this.params['page'] = 1;
                    this.load();
                }, 500
            ),
            loadHighlight(){
                apiRequest.send('get', '/article/highlight', {}, {})
                    .then(response => {
                        this.highlight = response;
                    });
            },
            load() {
                apiRequest.send('get', '/articles', {}, this.params)
                    .then(response => {
                        this.rows = response.data;
                        this.pagination = response;
                        this.loaded = true;
                    });
            },
            changePage(page) {
                this.loaded = false;
                this.params.page = page;
                this.load();
            },
            goTo: function (id) {
                location.href = route('hub.article.edit', id);
            },
            pin(row){
                    apiRequest.send('post', '/articles/' + row.id+'/highlight', {})
                    .then(response => {
                        CandyEvent.$emit('notification', {
                            level: 'success'
                        });
                        this.loadHighlight();
                        for(let x in this.rows){
                            this.rows[x].is_highlight=false;
                        }
                        row.is_highlight=true;
                    }).catch(response => {
                        CandyEvent.$emit('notification', {
                            level: 'error',
                            message: 'Something went wrong!'
                        });
                    });
            }
        }
    }
</script>

<template>
    <div>

        <!-- Tab panes -->
        <div class="tab-content section block">
            
          <form v-if="highlight">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="input-group input-group-full">
                                <span class="input-group-addon">
                                  <i style="
    color: #ffb200;
"  class="fa fa-star" aria-hidden="true"></i>
                                </span>
                                <label class="sr-only" for="star">Highlight</label>
                                <input type="text" class="form-control" placeholder="Highlight" v-model="highlight.title" disabled>
                            </div>
                        </div>
                    </div>
                </form>
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
                            <th style="width: 40px;"> <i class="fa fa-thumbtack" aria-hidden="true"></i></th>
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
                             <td @click="pin(row)">
                                <i v-if="!row.is_highlight" class="fa fa-star" aria-hidden="true"></i> <i  v-if="row.is_highlight" style="
    color: #ffb200;
" class="fa fa-star" aria-hidden="true"></i>
                            </td>
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
                    <candy-table-paginate :current="params.page" :total="pagination.last_page" @change="changePage"></candy-table-paginate>
                </div>
            </div>

        </div>
    </div>
</template>
