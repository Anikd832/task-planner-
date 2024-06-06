<template>
    <a class="m-0 popover-a cursor-pointer" 
        data-container="body" 
        data-trigger="hover" 
        data-toggle="popover" 
        data-html="true" 
        data-placement="bottom" 
        :data-content="content"
    >
        <i class="fas fa-info-circle"></i>
        <slot name="heading">
        </slot>
    </a>
    
</template>

<script>
    export default {
        props: {
            name: {
                type: String,
                default: 'popover'
            },

        	title: { 
                type: String,
                default: 'Page Status' 
            },

            classes: {
                type: [String, Array],
                default: ''
            },
            
            status: {
                type: String,
                default: ''
            },
        },
        mounted() {
            this.makeContent()
            this.makeTitle()
        },
        data() {
            return {
                content: '',
                original_title: '',
                statusArray: '',
            }
        },

        methods: {
            makeContent() {
                let list = ''; 
                list += "<ul class='m-0 px-0 py-0 list-unstyled list-popover'>";
                let statusArray = this.manageStatus()
                for (let i = 0; i < statusArray.length; i++) {
                    list += '<li class="capital-first font-size-12"><small class="bullett-' + this.removeWhiteSpace(statusArray[i]) + ' mr-2"></small>' + this.removeWhiteSpace(statusArray[i]) + '</li>';
                }
                list += "</ul>";
                this.content = list;
            },

            manageStatus() {
                return this.status.split(',')
            },
            
            makeTitle() {
                this.original_title = '<small class="font-medium px-0 py-0">' + this.title + '</small>';
            },

            removeWhiteSpace(string) {
                return string.replace(/\s+/g, '');
            }
        },

        computed: {
            
        },

        filters: {
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            }
        }
    }
</script>
