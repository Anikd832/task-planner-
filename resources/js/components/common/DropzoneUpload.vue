<template>
    <div :class="`dropzone ${disabledCls}`">
        <div class="dz-message" data-dz-message>
            <div class="dz-msg-inner">
                <i class="fas fa-cloud-upload-alt text-muted"></i>
                <h4 class="font-weight-normal">Drop here or click to upload</h4>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            endpoint: {
                type: String,
                default: '/tmp-upload'
            },

            formData: { 
                  type: Object,
                  default: function() {
                         return {}
                  }
            },

            maxfiles: {
                  default: 1
            },

            maxFilesize: {
                default: 10 
            },

            multiple: {
                type: Boolean,
                default: false
            },

            files: {
                default: null
            },

            disabled: {
                type: Boolean,
                default: false
            }
        },

        mounted() {     
            let self = this       
            let drop = new Dropzone(this.$el, {
                createImageThumbnails: true,
                parallelUploads: 1,
                addRemoveLinks: true,
                maxFiles: self.maxfiles,    
                maxFilesize: self.maxFilesize,
                uploadMultiple: self.multiple,    
                acceptedFiles: 'image/*,application/*,text/plain',
                url: self.endpoint,
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                },
            })

            /* drop.on('maxfilesexceeded', function(file) {
                this.removeAllFiles()
            }) */

            drop.on('sending', function(file, xhr, formData){
                for(let key in self.formData) {
                    formData.append(key, self.formData[key]);
                }
            })
                        
            drop.on('success', function(file, response) {
                  let data = (Array.isArray(response)) ? response[0] : response.data
                  file.id = data.id
                  file.fileType = data.type || data.type_name || data.document_type || data.collection_name
                  window.events.$emit('dropzone:uploaded', data)
                  
            })

            drop.on('removedfile', function(file) {
                  if(file.id) {
                        axios.delete(`${self.endpoint}/${file.id}`).then(response => {
                              window.events.$emit('dropzone:removed', {fileId: file.id, type: file.fileType})
                        }).catch(function(error) {
                              self.addFile(drop, file)
                        })
                  }
            })

            if(self.files) {
                  if(Array.isArray(self.files)) {
                        for(let file of self.files) {
                              self.addFile(drop, file)
                              self.complete(drop, file)
                        }
                  }

                if(typeof(self.files) == "object") {
                    self.addFile(drop, self.files)
                    self.complete(drop, self.files)
                }
            }

            if(self.disabled) {
                self.dropObj = drop
                self.dropzoneDisable()
            }
        },

        data() {
            return {
                disabledCls: '',
                dropObj: null
            }
        },

        watch: {
            disabled(newVal) {
                if(!newVal) {
                    this.dropzoneEnable()
                } else {
                    this.dropzoneDisable()
                    this.dropObj.removeAllFiles()
                }
            }
        },

        methods: {
            addFile(drop, file) {
                  if(file.id) {
                        drop.emit('addedfile', {
                              id: file.id,
                              name: file.name || file.file_name,
                              size: file.size,                        
                              fileType: file.type || file.type_name || file.document_type || file.collection_name
                        })
                  }
                  
            },

            complete(drop,  mockFile) {
                // Make sure that there is no progress bar, etc...
                drop.emit("complete", mockFile)

                // If you use the maxFiles option, make sure you adjust it to the
                // correct amount:
                var existingFileCount = 1; // The number of files already uploaded
                drop.options.maxFiles = drop.options.maxFiles - existingFileCount;
            },

            dropzoneEnable() {
                this.disabledCls = ''
                this.dropObj.enable()
            },

            dropzoneDisable() {
                this.disabledCls = 'dropzone-disabled'
                this.dropObj.disable()
            }
        }
    }
</script>

