<template>
    <table class="table fl-table mb-0">
        <thead>
            <slot name="header">
                <tr>
                    <th 
                        v-for="(column, index) in headers" 
                        class="cursor-pointer"
                        :class="`${activeSortClass(column)}`"
                        :key="index" 
                        @click="sortBy(column)">
                        <div v-if="hasCheckbox != 0 && hasCheckbox == index + 1" class="custom-control custom-checkbox">
                            <input name="color" value="primary" type="checkbox" class="custom-control-input" id="all-course" @click="selectAllCheckbox($event)">
                            <label class="custom-control-label" for="all-course"></label>
                        </div>
                        <span>
                            {{ column }}
                        </span>
                        <i 
                            v-if="isSortable(column)" 
                            class="ml-2 text-sm fa " 
                            :class="`${activeSortIconClass(column)}`"
                            ></i>
                    </th>
                </tr>
            </slot>
        </thead>
        <tbody>    
            <slot></slot> 
        </tbody>
    </table>
</template>

<script>

    export default {
        props: {
            headers: {
                type: Array,
                default: []
            },
            orderColumns: {
                type: Array,
                default: []
            },
            hasCheckbox: {
                type: Number,
                default: 0
            }
        },   

        mounted() {
            let {direction, order} = this.getUrlParams()
            
            if(direction && order) {
                this.sorting.sortClass = 'sorting_' + direction
                this.sorting.order = order
                this.sorting.direction = direction
            }
        },
        
        data() {
            return {
                sorting: {
                    sortClass: 'sorting',
                    order: '',
                    direction: 'desc'
                },
            }
        },

        methods: {   
            activeSortClass(column) {
                let idx = column.replace(/\s/g,'_').toLowerCase()
                
                if(idx == this.sorting.order) {
                    return this.sorting.sortClass
                } else if(this.orderColumns && this.orderColumns.indexOf(idx) > -1) {
                    return 'sorting'
                }
                return idx == 'actions' ? 'text-right' : ''
            },
            
            activeSortIconClass(column) {
                let idx = column.replace(/\s/g,'_').toLowerCase()
                let direction = this.sorting.direction == 'asc' ? 'up' : 'down'
                if(idx == this.sorting.order) {
                    return this.sorting.sortClass + ' fa-sort-' + direction
                } else if (this.orderColumns && this.orderColumns.indexOf(idx) > -1) {
                    return ' sorting fa-sort' 
                }
                return idx == '' ? ' text-left' : ''
            },

            isSortable(column) {
                let idx = column.replace(/\s/g,'_').toLowerCase()
                if (this.orderColumns && this.orderColumns.indexOf(idx) > -1) {
                    return true
                }
                return false
                
            },

            sortBy(column) {        
                let idx = column.replace(/\s/g,'_').toLowerCase()      
                if(this.orderColumns && this.orderColumns.indexOf(idx) > -1) {
                    if(idx != this.sorting.order) {
                        if(this.sorting['direction'] == 'desc') {                                
                            this.sorting['sortClass'] = 'sorting_asc'
                            this.sorting['direction'] = 'asc'
                        } else {                                
                            this.sorting['direction'] = 'asc'
                            this.sorting['sortClass'] = 'sorting_asc'
                        }
                    } else if(this.sorting['direction'] == 'desc') {
                        this.sorting['direction'] = 'asc'
                        this.sorting['sortClass'] = 'sorting_asc'
                    } else {
                        this.sorting['sortClass'] = 'sorting_desc'
                        this.sorting['direction'] = 'desc'
                    }

                    this.sorting['order'] = idx                    
                    this.$emit('order-by', this.sorting)
                }
            },

            selectAllCheckbox(event) {        
                var slides = document.getElementsByClassName("course-checkbox").forEach(function(checkbox) {
                    console.log()
                    if (event.target.checked == true) {
                        if (checkbox.checked == false) {
                            checkbox.click()
                        }
                    } else {
                        if (checkbox.checked == true) {
                            checkbox.click()
                        }
                    }
                });
            },
        }
    }
</script>
