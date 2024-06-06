<template>
    <div class="modal-header">
        <a href="javascript:" class="modal-back-btn cursor-pointer" @click="$modal.hide(name)">
            <i class="fal fa-angle-left"></i>
            <span class="ml-1 text-primary" v-html="title"></span>
        </a>
    </div>
</template>

<script>
    export default {
        props: {
        	name: {
                type: String,
                default: 'test-modal'
            },

            close: {
                type: Boolean, 
                default: true
            },
            
        	title: { 
                default: 'Back' 
            }
        },
        mounted() {
        }
    }
</script>
