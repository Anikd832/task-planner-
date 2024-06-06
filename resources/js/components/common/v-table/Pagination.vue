<template> 
    <div class="row" v-if="meta.total">
        <div class="col-sm-12 col-md-5 pt-10">
            <div class="dataTables_info mt-2 ml-2 mb-2">Showing {{ meta.from }} to {{ meta.to }} of {{ meta.total }} entries</div>
        </div>

        <div class="col-sm-12 col-md-7" v-if="meta.total && meta.last_page > 1">
            <div class="pagination-row pull-right">
                <ul class="pagination pr-1 pt-1" v-if="meta.last_page < 5">
                    <li v-for="(page, key) in meta.last_page" 
                        :key="key"
                        class="page-item" 
                        :class="{ active: meta.current_page == page }">
                        <a  href="#" class="page-link" @click.prevent="broadcast(page)">{{ page }}</a>
                    </li>
                </ul>

                <ul class="pagination pr-1 pt-1" v-else>
                    <li class="page-item" :class="{ disabled: meta.current_page == 1 }" >
                        <a  href="#" 
                            class="page-link" 
                            @click.prevent="broadcast(1)">
                            <i class="fa fa-fast-backward"></i>
                        </a>
                    </li>

                    <li class="page-item" :class="{ disabled: meta.current_page == 1}" >
                        <a  href="#" 
                            class="page-link" 
                            @click.prevent="broadcast(meta.current_page - 1)">
                            <i class="fa fa-backward"></i>
                        </a>
                    </li>                
          
                    <li v-for="(page, key) in _.range(min_page, max_page)" 
                        :key="key"
                        class="page-item"
                        :class="{ active: meta.current_page == page}">
                        <a  href="#" class="page-link" @click.prevent="broadcast(page)">{{ page }}</a>
                    </li>

                    <li class="page-item" :class="{ disabled: meta.current_page == meta.last_page }" >
                        <a  href="#" 
                            class="page-link" 
                            @click.prevent="broadcast(meta.current_page + 1)">
                            <i class="fa fa-forward"></i>
                        </a>
                    </li>

                    <li class="page-item" :class="{ disabled: meta.current_page == meta.last_page }" >
                        <a  href="#" 
                            class="page-link" 
                            @click.prevent="broadcast(meta.last_page)" >
                            <i class="fa fa-fast-forward"></i>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            meta: Object
        },

        data() {
            return {
                page: 0,
            }
        },

        computed: {
            _() {
                return _;
            },
            min_page(){
                let min_page = this.meta.current_page - 2;
                if (min_page <= 0) 
                    return 1;
                else if(min_page + 5 >= this.meta.last_page )
                    return this.meta.last_page-4
                else
                    return this.meta.current_page - 2;
            },
            max_page(){
                let max_page = this.min_page + 5;
                if(max_page > this.meta.last_page)
                    return  this.meta.last_page + 1
                else
                    return max_page
            },
            gotoPage() {
                const gotoData = [];
                for(let i = 5; i <= this.meta.last_page; i += 5) {
                    gotoData.push(i);
                }
                return gotoData;
            }
        },

        methods: {
            broadcast(page) {
                this.$emit('changed', page)
            }
        }
    }
</script>