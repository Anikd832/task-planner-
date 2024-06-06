<template>     
    <div id="dt_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_length" id="dt_length">
                    <label>Show
                        <select name="dt_length" 
                            v-model="limit"
                            class="form-control form-control-sm"
                            @change="handleChangeLimit"> 
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select> entries</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-6" v-if="searchBoxIsVisible">
                <slot name="search-box" :handleSearch="hasOwnSearchHandler">   
                    <div id="dt_filter" class="dataTables_filter">
                        <label>Search:
                            <input type="text" 
                                @keyup="handleSearch"
                                id="search-box-query" 
                                class="form-control form-control-sm" 
                                placeholder="search">
                        </label>
                    </div>                    
                </slot> 
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <table id="dt-table" class="table table-striped table-bordered dataTable">
                    <thead>
                        <slot name="header">
                            <tr role="row">
                                <th v-for="(column, index) in tblHeaders" 
                                    :key="index"
                                    :class="getActiveSortClassName(index)"
                                    @click="sortByColumn(index)"
                                >
                                    {{ column }}
                                </th>
                            </tr>
                        </slot>
                    </thead>
                    <tbody :class="(loading) ? 'loader' : ''">
                        <tr v-for="(item, itemKey) in getItems" :key="itemKey">     
                            <!-- main slot -->                         
                            <slot :data="item">     
                                <!-- it can add custom column initial of the tbody -->  
                                <slot name="start-columns" :data="item"></slot>

                                <td v-for="(column, colKey) in itemFields" :key="colKey">
                                    <span v-html="renderHtml(item, column)"></span>
                                </td>       

                                <!-- it can add custom column after end of the tbody -->   
                                <slot name="end-columns" :data="item">
                                    <td v-if="getActionButtons">
                                        <div class="pull-right">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button 
                                                    v-for="(button, btnKey) in getActionButtons"
                                                    :key="btnKey"
                                                    type="button" 
                                                    :class="`btn btn-flat btn-sm btn-${ (button == 'edit') ? 'default' : ((button == 'delete') ? 'danger' : ((button == 'view') ? 'primary' : 'info')) }`"
                                                    :title="button"
                                                    @click="broadcastAction(button, item)">
                                                    <i :class="`ft-${ (button == 'edit') ? 'edit-3' : ((button == 'delete') ? 'trash-2' : ((button == 'view') ? 'eye':'plus')) }`"></i>        
                                                </button>   
                                            </div>                                         
                                        </div>
                                    </td>
                                </slot>
                                <!-- ./end-columns slot -->
                            </slot>         
                            <!-- ./end-main slot -->
                        </tr>
                    </tbody>
                </table>
                
                <not-found v-if="items.length == 0"></not-found>
            </div>
        </div>
        
        <pagination :meta="meta" @changed="fetch"></pagination>                            
    </div>
</template>

<script>
    import BaseTable from './BaseTable'
    import { debounce } from 'lodash'

    export default {
        extends: BaseTable,
        props: {        
            searchBox: { 
                default: true 
            }
        },

        mounted() {
            const searchBox = document.getElementById('search-box-query');
            if(searchBox) {
                let searchVal = this.getUrlParams()['query'] || ''
                searchBox.value = searchVal
                this.searchQuery = searchVal
            }
        },

        data() {
            return {                
                searchQuery: '',
                sorting: {
                    sort_class: '',
                    sort_column: '',
                    sort_by: ''
                }
            }
        },

        computed: {
            searchBoxIsVisible() {
                return JSON.parse(this.searchBox)
            },
        },

        methods: {
            fetch(page) {
                this.loading = true
                this.page = page
                let requestParam = {
                    page: this.page,
                    limit: this.limit,
                }
                if(this.sorting['sort_column'] !== '') {
                    requestParam['order_col'] = this.sorting['sort_column']
                    requestParam['order_direction'] = this.sorting['sort_by']
                }
                
                requestParam['query'] = this.searchQuery

                const urlParams = this.buildURLQuery(requestParam)

                history.pushState(null, null, `?${urlParams}`)

                axios.get(`${this.url}?${urlParams}`).then(response => {
                    this.loading = false
                    this.dataItems = response.data
                });
            },

            getActiveSortClassName(key) {
                return (this.itemFields[key] == this.sorting.sort_column) ? this.sorting.sort_class : ' sorting'
            },

            sortByColumn(key) {
                let columnField = this.itemFields[key]
                
                if(!columnField.includes(".") && columnField !== undefined && columnField.charAt(0) !== '[') {
                    this.sorting['sort_column'] = columnField
                    if(this.sorting['sort_by'] == 'desc') {
                        this.sorting['sort_by'] = 'asc'
                        this.sorting['sort_class'] = 'sorting_asc'
                    } else {
                        this.sorting['sort_class'] = 'sorting_desc'
                        this.sorting['sort_by'] = 'desc'
                    }
                    this.fetch(this.page)                    
                }
            },

            handleChangeLimit() {
                let totalPage = Math.round(this.meta.total / this.limit)
                if(totalPage < this.page) {
                    this.fetch(totalPage)
                    return
                }
                if(totalPage > 0) {
                    this.fetch(this.page)
                }
            },

            handleSearch: debounce( function(e) {
                let inputVal = e.target.value               
                let strSearch = this.searchQuery
                if((strSearch == '' || strSearch === inputVal) && (inputVal.length <= 0 || strSearch === inputVal || inputVal.replace(/\s/g, "") == '')) {
                    return
                }

                this.searchQuery = inputVal
                this.fetch(1)   
            }, 500),

            hasOwnSearchHandler(slug) {
                if(slug !== false) {
                    return this.handleSearch(event)
                }
                this.$emit('event-search')
            }
        }
    }
</script>