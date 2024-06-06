<template>
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center card--header-body">
            <div :class="cardTitleClasses">
                <span v-html="title"></span>
            </div>

            <slot/>
        </div>
    </div>
</template>

<script>
    export default {
        props: { 
            name: 'card-title',

        	title: { 
                type: String,
                default: '' 
            },

            classes: {
                type: [String, Array],
                default: ''
            }
        },

        computed: {
            cardTitleClasses () {
                return ['card-title', this.classes]
            }
        }
    }
</script>

<style scoped>
    .card-header {
        padding: 0.2rem 1.25rem;
        border: 0;
    }

    .card--header-body {
        height: 45px;
    }
    
    .card-header .card-title {
        color: #252631;
        font-size: 0.875rem;
        font-weight: bold;
    }
</style>
