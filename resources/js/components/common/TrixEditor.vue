<template>
    <div class="trix-editor">
        <input type="hidden" :id="id" :name="name" :value="value">
        <trix-editor ref="trix" :input="id" :placeholder="placeholder"></trix-editor>
    </div>
</template>

<script>
    import Trix from 'trix'
    
    export default {
        name: 'v-trix-editor',
        
        props: {
            name: String,
            value: String,
            placeholder: String,
            shouldClear: {
                default: null
            },
            id: {
                default: 'trix'
            }        
        },

        mounted() {
            this.$refs.trix.addEventListener('trix-change', e => {
                this.$emit('input', e.target.innerHTML);
            });

            this.$watch('shouldClear', () => {
                this.$refs.trix.value = ''
            });
        }
    }
</script>