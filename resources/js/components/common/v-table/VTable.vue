<template>
    <transition name="pop-out">
        <div v-if="visible" class="v-table">
            <table class="table"
                :class="tblClass">
                <thead>
                    <slot name="header">
                        <tr>
                            <th v-for="(column, headKey) in tblHeaders" :key="headKey" v-text="column"></th>
                        </tr>
                    </slot>
                </thead>
                <tbody :class="loading ? 'loader' : ''">

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
                                        <button 
                                            v-for="(button, btnKey) in getActionButtons"
                                            type="button" 
                                            :key="btnKey"
                                            :class="`ml-2 btn btn-icons btn-sm btn-inverse-${ (button == 'edit') ? 'success' : ((button == 'delete') ? 'danger' : ((button == 'view') ? 'primary' : 'info')) }`"
                                            :title="button"
                                            @click="broadcastAction(button, item)">
                                            <i :class="`icon-${ (button == 'edit') ? 'note' : ((button == 'delete') ? 'trash' : ((button == 'view') ? 'users':'plus')) }`"></i>        
                                        </button>
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

            <pagination :meta="meta" @changed="fetch"></pagination> 
        </div>
    </transition>
</template>

<script>
    import BaseTable from './BaseTable'

	export default {
        extends: BaseTable,

        methods: { 
            fetch(page) {
                this.loading = true
                this.page = page

                const urlParams = this.buildURLQuery({page: page}, true)

                history.pushState(null, null, `?${urlParams}`)

                axios.get(`${this.url}?${urlParams}`).then(response => {
                    this.loading = false
                    this.dataItems = response.data
                });
            },
        }
	}
</script>