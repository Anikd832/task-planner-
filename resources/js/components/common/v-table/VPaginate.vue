<template>
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center ">
        <div class="dataTables_info">Showing {{ meta.from }} to {{ meta.to }} of {{ meta.total }} entries</div>

        <nav>
            <ul class="pagination mb-0">
                <li class="page-item" :class="{ disabled: meta.current_page == 1 }" >
                    <a  href="#"
                        class="page-link"
                        @click.prevent="broadcast(1)">
                        <i class="fas fa-fast-backward"></i>
                    </a>
                </li>

                <li class="paginate_button page-item previous" :class="{ disabled: meta.current_page == 1}" >
                    <a href="#"
                        class="page-link"
                        @click.prevent="broadcast(meta.current_page - 1)">
                        <i class="fal fa-angle-left"></i>
                    </a>
                </li>

                <li v-for="(page, key) in _.range(min_page, max_page)"
                    :key="key"
                    class="paginate_button page-item"
                    :class="{ active: meta.current_page == page}"
                    style="z-index: 0 !important;"
                >
                    <a href="#" class="page-link" @click.prevent="broadcast(page)">{{ page }}</a>
                </li>

                <li class="paginate_button page-item next" :class="{ disabled: meta.current_page == meta.last_page }" >
                    <a href="#"
                        class="page-link"
                        @click.prevent="broadcast(meta.current_page + 1)">
                        <i class="fal fa-angle-right"></i>
                    </a>
                </li>

                <li class="page-item" :class="{ disabled: meta.current_page == meta.last_page }" >
                    <a  href="#"
                        class="page-link"
                        @click.prevent="broadcast(meta.last_page)" >
                        <i class="fal fa-fast-forward"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <div>
            <label>
                Show <select
                    v-model="limit"
                    @change="handleOnChangePerPageLimit">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                    <option value="500">500</option>
                </select> entries
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            meta: Object
        },

        watch: {
            meta() {
                this.limit = this.meta.per_page
            }
        },

        data() {
            return {
                page: 1,
                limit: 10,
            }
        },

        computed: {
            _() {
                return _;
            },

            min_page(){
                let min_page = this.meta.current_page - 2
                if (min_page <= 1) {
                    return 1
                } else if(min_page + 5 >= this.meta.last_page ) {
                    let calcLimit = this.meta.last_page > 4 ? (this.meta.last_page - 4) : (4 - this.meta.last_page)
                    return calcLimit || 1
                } else {
                    return this.meta.current_page - 2
                }
            },

            max_page(){
                let max_page = this.min_page + 5
                if(max_page > this.meta.last_page) {
                    return this.meta.last_page + 1
                } else {
                    return max_page
                }
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
            }
        }
    }
</script>
