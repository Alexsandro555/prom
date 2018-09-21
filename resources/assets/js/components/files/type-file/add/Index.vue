<template>
    <v-flex xs4 offset-md4>
        <v-card>
            <v-container fluid grid-list-md>
                <v-layout row wrap>
                    <v-flex xs2></v-flex>
                    <v-flex xs8 center align-end flexbox>
                        <v-alert v-if="isAddSuccessful" :type="alertType" :value="true">
                            {{message}}
                        </v-alert>
                        <h2>Добавление нового типа файла</h2>
                        <v-form ref="formadd" v-model="valid" lazy-validation>
                            <v-text-field
                                    name="name"
                                    label="Имя типа файла"
                                    v-model="newTypeFile.name"
                                    :rules="titleRules"
                                    :counter="255"
                                    required>
                            </v-text-field>
                            <v-text-field
                                    name="size"
                                    label="Максимальный размер файла"
                                    v-model="newTypeFile.config.maxsize"
                                    :rules="sizeRules"
                                    suffix="KБ"
                                    required>
                            </v-text-field>
                            <v-text-field
                                    name="ext"
                                    label="Поддерживаемые расширения"
                                    v-model="newTypeFile.config.ext">
                            </v-text-field>
                            <v-checkbox
                                    label="Изображение"
                                    v-model="flagImg"
                            ></v-checkbox>


                            <div v-if="flagImg">
                                <div v-for="sizes in newTypeFile.config.resize">
                                    <v-layout col wrap>
                                        <v-flex xs3>
                                            <v-text-field
                                                    name="sizes.name"
                                                    label="Имя"
                                                    v-model="sizes.name"
                                                    required></v-text-field>
                                        </v-flex>
                                        <v-flex xs3>
                                            <v-text-field
                                                    name="sizes.width"
                                                    label="Ширина"
                                                    v-model="sizes.width"
                                                    required></v-text-field>
                                        </v-flex>
                                        <v-flex xs3>
                                            <v-text-field
                                                    name="sizes.height"
                                                    label="Высота"
                                                    v-model="sizes.height"
                                                    required></v-text-field>
                                        </v-flex>
                                        <v-flex xs1>
                                            <v-checkbox
                                                    v-model="sizes.absolute"
                                            ></v-checkbox>
                                        </v-flex>
                                        <v-flex xs2>
                                            <v-btn small color="error"  @click.prevent="delNewResize(newTypeFile,sizes.name,newTypeFile.id)">Удалить</v-btn>
                                        </v-flex>
                                    </v-layout>
                                </div>
                                <v-layout col wrap>
                                    <v-flex xs3>
                                        <v-text-field
                                                name="curNewFormatFile.name"
                                                label="Имя"
                                                v-model="curNewFormatFile.name"></v-text-field>
                                    </v-flex>
                                    <v-flex xs3>
                                        <v-text-field
                                                name="scurNewFormatFile.width"
                                                label="Ширина"
                                                v-model="curNewFormatFile.width"></v-text-field>
                                    </v-flex>
                                    <v-flex xs3>
                                        <v-text-field
                                                name="curNewFormatFile.height"
                                                label="Высота"
                                                v-model="curNewFormatFile.height"></v-text-field>
                                    </v-flex>
                                    <v-flex xs1>
                                        <v-layout row wrap class="light--text">
                                            <v-checkbox
                                                    v-model="curNewFormatFile.absolute"
                                                    hide-details
                                            ></v-checkbox>
                                        </v-layout>
                                    </v-flex>
                                    <v-flex xs2>
                                        <v-btn small color="primary"  @click.prevent="addNewResize(newTypeFile.config.resize,newTypeFile.id)">Добавить</v-btn>
                                    </v-flex>
                                </v-layout>
                            </div>

                            <v-btn large color="primary" :disabled="!valid" @click.prevent="addNewType('form-add',newTypeFile)">Добавить</v-btn>
                        </v-form>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card>
    </v-flex>
</template>
<script>
    export default {
        props: { },
        data: function() {
            return {
                defTypeFile: {
                    name: "",
                    config: {
                        ext: '',
                        maxsize:'',
                        resize: []
                    }
                },
                newTypeFile: {
                    name: "",
                    config: {
                        ext: '',
                        maxsize:'',
                        resize: []
                    }
                },
                curNewFormatFile: {
                    name:'',
                    width:'',
                    height:'',
                    absolute:false
                },
                valid: false,
                flagImg: false,
                titleRules: [
                    v => !!v || 'Обязательно для заполнения',
                    v => v.length <=255 || 'Длина должна быть не более 255 символов'
                ],
                sizeRules: [
                    v => !!v || 'Обязательно для заполнения',
                    v => Number(v)<=20000 || 'Значение не должно превышать 20000 КБ'
                ],
                isAddSuccessful: false,
                message: '',
                alertType: 'info'
            }
        },
        mounted: function() {
        },
        methods: {
            addNewResize(element,id) {
                var obj = {
                    name: this.curNewFormatFile.name,
                    width: this.curNewFormatFile.width,
                    height: this.curNewFormatFile.height,
                    absolute: this.curNewFormatFile.absolute
                }
                element.push(obj);
                this.curNewFormatFile.name = '';
                this.curNewFormatFile.width = '';
                this.curNewFormatFile.height = '';
                this.curNewFormatFile.absolute = false;
            },
            delNewResize(element,name,id) {
                element.config.resize.forEach(function(item,index) {
                    if(item.name === name) {
                        element.config.resize.splice(index,1);
                    }
                });
            },
            addNewType(scope, newTypeFile) {
                if(this.$refs.formadd.validate()) {
                    this.valid = false;
                    axios.post('/files/type-files/add', {typefile: newTypeFile}).then((response) => {
                        this.$refs.formadd.reset();
                        this.newTypeFile = {...this.defTypeFile};
                        //this.addDisabled = false;
                        this.isAddSuccessful = true;
                        this.message = response.data.message;
                        setTimeout((res) => {this.isAddSuccessful = false }, 2000);
                    }).catch(error => {
                        //this.alertType = 'error';
                        //this.message = error;
                        console.log(error);
                    });
                }
            },
        }
     }
</script>