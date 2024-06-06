<template>
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center row">
        <div>
            <label>
                Show
                <select class="select-page-limit"
                    v-model="limit"
                    @change="handleOnChangePerPageLimit">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                    <option value="500">500</option>
                </select>
                entries
            </label>
        </div>
        <slot name="filters">

        </slot>
        <div class="w-25">
            <input
                type="search"
                placeholder="Search:"
                v-model="filterString"
                class="dataTables_filter_search"
                @keyup="handleSearch"
                @change="handleSearch"
                aria-controls="">
        </div>
    </div>
</template>
<style scoped>
    .select-page-limit {
        width: 80px;
        height: 30px !important;
        padding: 0px 10px !important;
        border: 1px solid #aaa;
        border-radius: 3px;
        background-color: transparent;
    }

    .dataTables_filter_search {
        width: 97%;
        border: 1px solid #aaa;
        border-radius: 3px;
        padding: 5px;
        background-color: transparent;
        margin-left: 3px;
    }
</style>
<script>
    export default {
        props: {
            meta: Object
        },

        watch: {
            meta() {
                this.limit = this.meta.per_page
            },

            filterString(value) {
                if (value == '') {
                    this.$emit('search', '')
                }

                this.$store.dispatch('updateSearchStr', {
                    search_str: value
                })
            },

            searchStrFromStore() {
                this.filterString = this.$store.state.search_str
            },
        },

        data() {
            return {
                page: 1,
                limit: 10,
                searchQuery: '',
                filterString: ''
            }
        },

        computed: {
            _() {
                return _;
            },

            gotoPage() {
                const gotoData = [];
                for(let i = 5; i <= this.meta.last_page; i += 5) {
                    gotoData.push(i);
                }
                return gotoData;
            },

            searchStrFromStore() {
                this.filterString = this.$store.state.search_str
            },
        },

        mounted() {

        },

        methods: {
            broadcast(page, limit = this.limit) {
                this.$emit('changed', { page, limit })
            },

            handleOnChangePerPageLimit() {
                let totalPage = Math.round(this.meta.total / this.limit)
                if(totalPage < this.page) {
                    this.broadcast(totalPage, this.limit)
                    return
                }
                if(totalPage > 0) {
                    this.broadcast(this.page, this.limit)
                }
            },

            handleSearch: _.debounce( function(e) {
                let inputVal = e.target.value
                let strSearch = this.searchQuery
                if((strSearch == '' || strSearch === inputVal) && (inputVal.length <= 0 || strSearch === inputVal || inputVal.replace(/\s/g, "") == '')) {
                    return
                }
                this.searchQuery = inputVal
                if (this.searchQuery != '') {
                    this.$emit('search', this.searchQuery)
                }
            }, 500),
        }
    }
</script>
