<template>
    <div>
        <p>Загрузчик файлов</p>

        <Dropzone id="myVueDropzone" :options="dzOptions" ref="myVueDropzone" :include-styling="false"></Dropzone>
    </div>
</template>

<script>
    import Dropzone from 'vue2-dropzone'

    export default {
        props: {
            'url': {
                type: String,
                required: true
            },
            'elementId': {
                type: Number,
                required: true
            },
            'typeFiles' :  {
                type: Array,
                required: true
            }
        },
        data: function() {
            return {
                //csrfToken: Laravel.csrfToken,
                dzOptions: {
                    dictDefaultMessage: '<br>Переместите файлы для загрузки ',
                    url: this.url,
                    thumbnailWidth: 150,
                    maxFilesize: 0.5,
                    previewTemplate: this.template(),
                },
            }
        },
        components: {
            Dropzone
        },
        methods: {
            template() {
                return `
                    <div class="dz-preview dz-file-preview">
                        <div class="dz-image">
                            <div data-dz-thumbnail-bg></div>
                        </div>
                        <div class="dz-details">
                            <div class="dz-size"><span data-dz-size></span></div>
                            <div class="dz-filename"><span data-dz-name></span></div>
                        </div>
                        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                        <div class="dz-error-message"><span data-dz-errormessage></span></div>
                        <div class="dz-success-mark"><i class="fa fa-check"></i></div>
                        <div class="dz-error-mark"><i class="fa fa-close"></i></div>
                    </div>
            `;
            },
            'showSuccess': function (file,data) {
                var $element = document.getElementById("files-id");
                var ids = JSON.parse($element.value);
                //console.log('Data:'+data);
                //console.log('File:'+file);
                ids.push(data.id);
                $element.value = JSON.stringify(ids);
            },
            'showError': function (file) {
                console.log(JSON.stringify(file.upload));
            },
            'fileRemoved': function(file)  {
                let id = file.id;
                if(id) {
                    this.axios.get('/files/deleteFile/'+id, {}).then(function (response) {
                    }).catch(function (error)
                    {
                        console.log(error);
                    });
                }
                else {
                    console.log('Не существующий id')
                }
            },
            'dropzoneMounted': function () {
                let that = this;
                let dropzone = this.$refs.myVueDropzone;
                this.axios.get('/files/getFiles/'+that.elementId, {}).then(function (response)
                {
                    let data = response.data;
                    data.forEach(function(item) {
                        if(item.config.files["s-medium"]) {
                            let id = item.id;
                            let filename = item.config.files["s-medium"].filename;
                            let size = item.config.files["s-medium"].size;
                            let mockFile = {id: id, name: filename, size: size};
                            dropzone.manuallyAddFile(mockFile,"/storage/"+filename,null,null,{dontSubstractMaxFiles: false, addToFiles: true});
                        }
                    });
                }).catch(function (error)
                {
                    console.log(error);
                });
            }
        }
    }
</script>


<style>
    #customdropzone {
        background-color: orange;
        font-family: 'Arial', sans-serif;
        letter-spacing: 0.2px;
        color: #777;
        transition: background-color .2s linear;
        height: 200px;
        padding: 40px;
    }

    #customdropzone .dz-preview {
        width: 160px;
        display: inline-block
    }
    #customdropzone .dz-preview .dz-image {
        width: 80px;
        height: 80px;
        margin-left: 40px;
        margin-bottom: 10px;
    }
    #customdropzone .dz-preview .dz-image > div {
        width: inherit;
        height: inherit;
        border-radius: 50%;
        background-size: contain;
    }
    #customdropzone .dz-preview .dz-image > img {
        width: 100%;
    }

    #customdropzone .dz-preview .dz-details {
        color: white;
        transition: opacity .2s linear;
        text-align: center;
    }
    #customdropzone .dz-success-mark, .dz-error-mark, .dz-remove {
        display: none;
    }
</style>

