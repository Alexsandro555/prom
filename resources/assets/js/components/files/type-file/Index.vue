<template>
    <v-container  grid-list-md text-xs-center>
        <v-layout row wrap>
            <v-flex xs12 align-center>
                <type-file-add></type-file-add>
            </v-flex>
            <v-flex xs4 offset-md4 v-for="typeFile in typeFiles" :key="typeFile.id">
                <v-card>
                    <v-container fluid grid-list-md>
                        <v-layout row wrap>
                            <v-flex xs2></v-flex>
                            <v-flex xs8 center align-end flexbox>
                                <v-form :ref="'form-type-file-'+typeFile.id" v-model="valid" lazy-validation>
                                    <v-text-field
                                            name="name"
                                            label="Имя типа файла"
                                            v-model="typeFile.name"
                                            :rules="titleRules"
                                            :counter="255"
                                            disabled
                                            required>
                                    </v-text-field>
                                    <v-text-field
                                            name="size"
                                            label="Максимальный размер файла"
                                            v-model="typeFile.config.maxsize"
                                            :rules="sizeRules"
                                            suffix="KБ"
                                            required>
                                    </v-text-field>
                                    <v-text-field
                                            name="ext"
                                            label="Поддерживаемые расширения"
                                            v-model="typeFile.config.ext">
                                    </v-text-field>
                                    <div v-if="!isEmptyObject(typeFile.config.resize)">
                                        <strong>Форматы изображений</strong>
                                        <div v-for="sizes in typeFile.config.resize">
                                            <v-layout col wrap>
                                                <v-flex xs3>
                                                    <v-text-field
                                                            name="sizes.name"
                                                            label="Имя"
                                                            v-model="sizes.name"
                                                            required
                                                            disabled>
                                                    </v-text-field>
                                                </v-flex>
                                                <v-flex xs3>
                                                    <v-text-field
                                                            name="sizes.width"
                                                            label="Ширина"
                                                            v-model="sizes.width"
                                                            required>
                                                    </v-text-field>
                                                </v-flex>
                                                <v-flex xs3>
                                                    <v-text-field
                                                            name="sizes.height"
                                                            label="Высота"
                                                            v-model="sizes.height"
                                                            required>
                                                    </v-text-field>
                                                </v-flex>
                                                <v-flex xs1>
                                                    <v-checkbox
                                                            v-model="sizes.absolute"
                                                    ></v-checkbox>
                                                </v-flex>
                                                <v-flex xs2>
                                                    <v-btn small color="error"  @click.prevent="delResize(typeFile,sizes.name,typeFile.id)">Удалить</v-btn>
                                                </v-flex>
                                            </v-layout>
                                        </div>
                                        <v-layout row wrap>
                                            <v-form :ref="'form-add-format-'+typeFile.id" v-model="validAddFormat[typeFile.id]" lazy-validation>
                                                <v-layout row wrap>
                                                    <v-flex xs3>
                                                        <v-text-field
                                                                name="curNewFormatFile.name"
                                                                label="Имя"
                                                                v-model="curTypeFile[typeFile.id].name"
                                                                :rules="titleRules"
                                                                required></v-text-field>
                                                    </v-flex>
                                                    <v-flex xs3>
                                                        <v-text-field
                                                                name="scurNewFormatFile.width"
                                                                label="Ширина"
                                                                v-model="curTypeFile[typeFile.id].width"
                                                                :rules="intRules"
                                                                required></v-text-field>
                                                    </v-flex>
                                                    <v-flex xs3>
                                                        <v-text-field
                                                                name="curNewFormatFile.height"
                                                                label="Высота"
                                                                v-model="curTypeFile[typeFile.id].height"
                                                                :rules="intRules"
                                                                required></v-text-field>
                                                    </v-flex>
                                                    <v-flex xs1>
                                                        <v-layout row wrap class="light--text">
                                                            <v-checkbox
                                                                    v-model="curTypeFile[typeFile.id].absolute"
                                                                    hide-details
                                                            ></v-checkbox>
                                                        </v-layout>
                                                    </v-flex>
                                                    <v-flex xs2>
                                                        <v-btn small color="primary" :disabled="!validAddFormat[typeFile.id]" @click.prevent="addResize('add-resize',typeFile.config.resize,typeFile.id)">Добавить</v-btn>
                                                    </v-flex>
                                                </v-layout>
                                            </v-form>
                                        </v-layout>
                                    </div>
                                    <v-btn large color="primary"  @click.prevent="save('form-save'+typeFile.id,typeFile)">Сохранить</v-btn>
                                </v-form>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
    import TypeFileAdd from './add';
    export default {
        data: function() {
            return {
                /*curTypeFile: {
                    name:'',
                    width:'',
                    height:'',
                    absolute:false
                },*/
                curTypeFile: [],
                typeFiles: [],
                isAddSuccessful: false,
                isSaveSuccessful: false,
                message: '',
                valid: false,
                validAddFormat: [],
                titleRules: [
                    v => !!v || 'Обязательно для заполнения',
                    v => v.length <=255 || 'Длина должна быть не более 255 символов'
                ],
                sizeRules: [
                    v => !!v || 'Обязательно для заполнения',
                    v => Number(v)<=20000 || 'Значение не должно превышать 20000 КБ'
                ],
                intRules: [
                    v => !!v || 'Обязательно для заполнения',
                    v => Number.isInteger(Number(v)) || 'Значение должно быть целым числом'
                ]
            }
        },
        created() {
            axios.get('/files/type-files',{}).then((response) => {
                this.typeFiles = response.data
                this.curTypeFile.push({id: 0, name: '', width: '', height: '', absolute: false, valid: false})
                response.data.forEach((item) => {
                    this.curTypeFile.push({id: item.id, name: '', width: '', height: '', absolute: false, valid: false})
                    this.validAddFormat[item.id] = false;
                })
            }, function(response) {
                console.log('Error: '+JSON.stringify(response.data.message));
            });
        },
        components: {
            'type-file-add': TypeFileAdd
        },
        methods: {
            addResize(scope, element,id) {
                if(this.$refs['form-add-format-'+id][0].validate()) {
                    const obj = {
                        name: this.curTypeFile[id].name,
                        width: this.curTypeFile[id].width,
                        height: this.curTypeFile[id].height,
                        absolute: this.curTypeFile[id].absolute
                    }
                    axios.post('/files/type-files/add-format', {typeFile: obj, id: id})
                        .then((response) => {
                            this.$refs['form-add-format-'+id][0].reset();
                            element.push(obj);
                            this.isSaveSuccessful = true;
                            this.message = response.data.message;
                            setTimeout((res) => {this.isSaveSuccessful = false }, 2000);
                            this.curTypeFile[id].name = '';
                            this.curTypeFile[id].width = '';
                            this.curTypeFile[id].height = '';
                            this.curTypeFile[id].absolute = false;
                        }).catch(error => {
                            console.log(error);
                        });
                }
                else {
                    alert('Заполните поля')
                }
            },
            delResize(typeFile,name,id) {
                typeFile.config.resize.forEach(function(item,index) {
                    if(item.name === name) {
                        typeFile.config.resize.splice(index,1);
                    }
                });
                axios.post('/files/type-files/del-format', {name: name, id: id})
                    .then((response) => {
                        this.isSaveSuccessful = true;
                        this.message = response.data.message;
                        setTimeout((res) => {this.isSaveSuccessful = false }, 2000);
                    }).catch(error => {
                        console.log(error);
                    })
            },
            save(scope, typeFile) {
                //if(this.$refs['form-type-file-'+typeFile.id][0].validate()) {
                    axios.post('/files/type-files/update', {typefile: typeFile})
                        .then((response) => {
                            this.isSaveSuccessful = true;
                            this.message = response.data.message;
                            setTimeout((res) => {
                                this.isSaveSuccessful = false
                            }, 2000);
                        }).catch(error => {
                        console.log(error);
                    })
                /*}
                else {
                    alert('Заполните поля')
                }*/
            },

            isEmptyObject(obj) {
                if(typeof(obj)!== undefined && obj)
                {
                    return Object.keys(obj).length === 0;
                }
                else
                {
                    return true;
                }
            }
        }
    }
</script>

<style scoped>
    .type-file-name {
        width: 600px;
    }
    .header {
        font-size: 1.2em;
        color: #3E78A5;
        font-weight: bold;
    }
    .error-border {
        border-color: red;
    }
</style>