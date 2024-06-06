<script>
    export default {
        props: {
            code: {
                type: String,
                default: 'code'
            },
            contentValue: {
                type: String,
                default: ''
            },
        },

        computed: {
            summernote() {
                return $(this.$refs.summernote);
            },

            value() {
                return this.contentValue
            }
        },

        watch: {
            'value': function(value) {
                $(this.$refs.summernote).summernote(this.code, value)
            },
        },

        mounted() {
            $(this.$refs.summernote).summernote({
                height: 150,
                fontNames: [
                    'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact',
                    'Tahoma', 'Times New Roman', 'Verdana', 'Nunito', 'Segoe UI', 'arial',
                    '"Noto Sans Bengali"', 'sans-serif'
                ],
                placeholder: 'write here...',
                lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
                toolbar: [
                    ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['lineHeight', ['1']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['hr', ['hr']],
                    ['codeview', ['codeview']],
                    ['insert', ['link']],
                ]
            });
            $(this.$refs.summernote).summernote(this.code, this.value)
        },

        created() {
            this.summernote.summernote({
                heigh: 300
            })
        },
        methods: {
            getVal() {
                var data  = $(this.$refs.summernote).summernote('code');
                return data;
            },
        }
    }
</script>
<template>
    <textarea ref="summernote" id="summernote" />
</template>
