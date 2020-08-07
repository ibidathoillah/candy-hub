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
                selected: [],
                settings: {},
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
            CandyEvent.$on('settings-updated', event => {
                this.loaded = false;
                this.load(this.id);
            });

            Dispatcher.add('save-settings', this);
        },
        methods: {
            save() {
                console.log("saved settings")
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
            /**
             * Loads the product by its encoded ID
             * @param  {String} id
             */
            load(id) {
                apiRequest.send('get', '/settings/', {})
                .then(response => {

                    this.settings = response;
                    this.loaded = true;
 
                }).catch(error => {
                    CandyEvent.$emit('notification', {
                        level: 'error',
                        message: error.message
                    });
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
                    <h3>// TODO: Input for Setting FAQ, Terms, and any static contents</h3>
                    <h4>{{ JSON.stringify(settings) }}</h4>
                    <!-- <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="article.title">
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" class="form-control" v-model="article.slug">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Content</label>
                        <candy-textarea :id="'default-content'"
                                        :richtext="true"
                                        v-model="article.body">
                        </candy-textarea>
                    </div> 
                                    <div class="form-group">
                        <label>Tag</label>
                        <candy-taggable v-model="article.tags">
                        </candy-taggable>
                    </div>  -->
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
