<template>
    <select ref="select2">
        <slot></slot>
    </select>
</template>

<script>
    import 'select2/dist/js/select2.min.js'

    export default {
        props: ['options', 'value'],
        mounted() {
            let self = this
            $(this.$el)
                // init select2
                .select2({ data: this.options })
                .val(this.value)
                .trigger('change')
                // emit event on change.
                .on('change', function () {
                    self.$emit('input', $(this).val())
                })
        },
        watch: {
            value: function (value) {
                if(!$(this.$el).val()) {
                    return
                }
                //$(this.$el).val(value).trigger('change')
                // update value
                if ([...value].sort().join(",") !== [...$(this.$el).val()].sort().join(","))
                    $(this.$el).val(value).trigger('change')
            },
            options: function (options) {
                // update options
                //$(this.$el).empty().select2({ data: options })
                $(this.$el).select2({ data: options })
            }
        },
        destroyed() {
            $(this.$el).off().select2('destroy')
        }
    }
</script>
