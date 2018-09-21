<template>
        <div>
                <div id="editor"></div>
        </div>
</template>
<script>
    import vueditor from '../vueditor/dist/script/vueditor.min.js'
    import '../vueditor/dist/style/vueditor.min.css'
    export default {
        data: () => {
            return {
                inst: null,
            }
        },
        props: {
            'url': String,
            'fileUrl': String,
            'elementId': {
                type: Number,
                required: true
            },
            'name': {
                type: String,
                required: true
            },
            'urlFile': {
                type: String,
                required: true
            },
            'typeFile':{
                type: String,
                required: true
            },
            'typeFileUpload':{
                type: String,
                required: true
            },
            'value': String,
            /*'value': {
                type: String,
                required: true
            },*/
            'model': {
                type: String,
                required: true
            }
        },
        computed: {
          descVal() {
              return this.inst?this.inst.getContent():'';
          }
        },
        watch: {
          descVal(val) {
             this.$emit('input',val);
          },
          value(val) {
              this.inst.setContent(val);
          }
        },
        mounted() {
            let inst = vueditor.createEditor('#editor', {
                uploadUrl: '/files/'+this.url,
                uploadFile: '/files/'+this.urlFile,
                fileableId: this.elementId,
                typeFiles: this.typeFile,
                model: this.model,
                id: 'product-wysiwyg',
                classList: ['product-wysiwyg'],
            });
            this.inst = inst;
            //inst.setContent(this.value);
        }
    }
</script>

<style>
        .product-wysiwyg {
                min-height: 350px;
        }
</style>