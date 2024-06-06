<template>
    <div class="list-preloader" v-show="action">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
        	action: {
                type: Boolean,
                default: false
            },

            classes: {
                type: [String, Array],
                default: ''
            },
        },
        mounted() {
            
        },

        methods: {
            
        },
    }
</script>
