<!--
  Product Edit
  This component is responsible for displaying the product edit page.
 -->
<script>
    export default {
        data() {
            return {
                title: '',
                loaded: false,
                countries: [],
                selected: [],
                article: {},
                keywords: ''
            }
        },
        props: {
            id: {
                type: String,
                required: true
            }
        },
        created() {
            this.load(this.id);
            this.countryCache = [];
        },
        mounted() {
            CandyEvent.$on('article-updated', event => {
                this.loaded = false;
                this.load(this.id);
            });

            Dispatcher.add('save-articles', this);

            this.loadCountries();
        },
        methods: {
            loadCountries() {
                apiRequest.send('GET', '/countries').then(response => {
                    this.countries = response.data;
                    this.countryCache = response.data;
                });
            },
            save() {
                this.article.countries = this.selected;
                apiRequest.send('PUT', '/articles/' + this.article.id, this.article).then(response => {
                    CandyEvent.$emit('notification', {
                        level: 'success'
                    });
                }).catch(response => {
                    CandyEvent.$emit('notification', {
                        level: 'error',
                        message: response.message
                    });
                });
            },
            getFlag: function(locale) {
                if (locale == 'en') {
                    locale = 'gb';
                }
                return 'flag-icon-' + locale.toLowerCase();
            },
            selectAll(region) {
                _.each(region.countries.data, country => {
                    if (!_.includes(this.selected, country.id)) {
                        this.selected.push(country.id);
                    }
                });
            },
            selectedCount(region) {
                var count = 0;
                _.each(region.countries.data, country => {
                    if (_.includes(this.selected, country.id)) {
                        count++;
                    }
                });
                return count;
            },
            deselect(region) {
                var indexes = [],
                    selected = [];

                var ids = _.map(region.countries.data, item => {
                    return item.id;
                });

                this.selected = _.filter(this.selected, item => {
                    return !ids.includes(item);
                });
            },
            isSelected(id) {
                return this.selected.includes(id);
            },
            getCache() {
                return JSON.parse(JSON.stringify(this.countryCache));
            },
            search() {
                this.countries = this.getCache();
                if (this.keywords) {
                    this.countries = this.countries.filter(region => {
                        region.countries.data = _.filter(region.countries.data, country => {
                            return !(country.name.en.indexOf(this.keywords) == -1);
                        });
                        return region.countries.data.length;
                    });
                }
            },
            /**
             * Loads the product by its encoded ID
             * @param  {String} id
             */
            load(id) {
                apiRequest.send('get', '/articles/' + id, {})
                .then(response => {
                    this.article = response;
                    this.loaded = true;

                    CandyEvent.$emit('title-changed', {
                        title: this.article.title
                    });

                    document.title = this.article.title + ' Articles';

                    // apiRequest.send('GET', 'currencies/' + this.order.currency).then(response => {
                    //     this.currency = response.data;
                    //     this.loaded = true;
                    // });
                }).catch(error => {
                });
            }
        }
    }
</script>

<template>
    <div>
        <template v-if="loaded">
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="article.title">
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-xs-12 col-md-8">
                            <div class="input-group input-group-full">
                                <span class="input-group-addon">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </span>
                                <label class="sr-only" for="search">Search</label>
                                <input type="text" class="form-control" id="search" placeholder="Search" @keyup="search" v-model="keywords">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <div v-else>
            <div class="page-loading loading">
                <span><i class="fa fa-sync fa-spin fa-3x fa-fw"></i></span> <strong>Loading</strong>
            </div>
        </div>

    </div>

</template>

<style lang="scss" scoped>
    .region {
        header {
            margin:2em 0 1em 0;
        }
        ul {
            -moz-column-count: 4;
            -moz-column-gap: 20px;
            -webkit-column-count: 4;
            -webkit-column-gap: 20px;
            column-count: 4;
            column-gap: 20px;
            list-style:none;
            padding:0;
            label {
                margin-bottom:0;
                border-bottom:1px solid rgb(224, 224, 224);
                padding:5px 0;
                &.selected {
                    border-color:rgb(104, 174, 255);
                }
                input {
                    margin-right:5px;
                }
            }
        }
    }
</style>
