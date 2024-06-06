import Pagination from './Pagination'
import { objectValueByKey } from '../../../mixin/object-value-by-key'

export default Vue.extend({
            props: {
                tblClass: {
                    type: String,
                    default: 'table-striped table-bordered mb-0'
                },

                headers: {
                    type: String
                },

                fields: {
                    type: String
                },

                data: {
                    required: true
                },

                url: {
                    default: window.location.href.split('?')[0]
                },

                endpoint: {
                    default: false
                },

                pushState: {
                    default: true
                },

                actionButtons: String,

                visible: {
                    type: Boolean,
                    default: true
                }
            },

            mixins: [objectValueByKey],

            mounted() {
                this.dataItems = this.data
            },

            data() {
                return {
                    loading: false,
                    items: [],
                    dataItems: [],
                    page: 0,
                    limit: 10,
                    meta: {
                        total: 0,
                        per_page: 0,
                        current_page: 0,
                        last_page: 0,
                        next_page_url: 0,
                        prev_page_url: 0,
                        from: 0,
                        to: 0
                    }
                }
            },

            components: {
                Pagination
            },

            watch: {
                data() {
                    this.dataItems = this.data
                }
            },

            computed: {
                tblHeaders() {
                    if (this.headers === undefined)
                        return []

                    return this.headers.split(',')
                        .map(label => label.replace(/\b\w/g, l => l.toUpperCase()))
                },

                itemFields() {
                    if (this.fields === undefined)
                        return []

                    return this.fields.replace(/\,\s+/g, ',').split(',')
                },

                getItems() {
                    this.pushItemOrMetaData(this.dataItems)
                    return this.items
                },

                getActionButtons() {
                    if (this.actionButtons !== undefined)
                        return this.actionButtons.replace(/\s/g, '').toLowerCase().split(',')

                    return false
                }
            },

            methods: {
                // Render column based data
                renderHtml(item, column) {
                    let regx = /\[(.*?)\]/g
                    if (column.charAt(0) == '[' && column.match(regx)) {
                        let keys = column.replace(regx, "$1").split('|')
                        let [type] = keys
                        if (type == 'img') {
                            return this.renderImage(item, keys)
                        } else if (type == 'loop') {
                            return this.renderLoop(item, keys)
                        }
                    }
                    return this.getObjValueByKey(item, column)
                },

                // Render image data
                renderImage(item, keys) {
                    let [type, column, clsName, height] = keys
                    let imgVal = this.getObjValueByKey(item, column)
                    return `<img src="${imgVal || '/images/avatar.png'}" class="${clsName}" height="${height}" alt="Preview Image" />`
                },

                // Render multiple data in single column
                renderLoop(item, keys) {
                    const self = this
                    let [type, column, fields, clsName] = keys
                    if (fields == undefined)
                        fields = 'name'

                    if (clsName == undefined)
                        clsName = 'label'

                    fields = fields.split(':')
                    let data = this.getObjValueByKey(item, column)
                    if (Array.isArray(data)) {
                        return `
                    ${data.map(val => {
                        return `<small class="${(clsName == 'text' ? '' : `${clsName} ${self.labelColor()}`)}">${
                            fields.map(key => self.getObjValueByKey(val, key)).join(' : ')
                        }</small>`  
                    }).join(' ')}`
                }

            return ''
        },
    
        // initial meta data & items array
        pushItemOrMetaData(response) {
            if(response !== undefined && response !== '' && response !== null && typeof response !== 'string') {
                const self = this;  
                if('data' in response) {
                    self.items = response.data;
                    self.meta.total = response.total;
                    self.meta.per_page = response.per_page;
                    self.meta.current_page = response.current_page;
                    self.meta.last_page = response.last_page;
                    self.meta.next_page_url  = response.next_page_url;
                    self.meta.prev_page_url  = response.prev_page_url;
                    self.meta.from  = response.from;
                    self.meta.to   = response.to;                
                    self.limit = self.meta.per_page
                } else {
                    self.items = response
                }
            }
        },
        
        // broadcast event child to parent
        broadcastAction(...params) {
            return this.$emit('event-action', ...params)
        },
    }
});