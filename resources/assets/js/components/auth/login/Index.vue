<template>
    <v-dialog v-model="active" persistent max-width="500px" class="text-xs-center">
        <v-card>
            <v-card-media dark height="100px" class="register-head">
                <v-flex xs11 offset-xs1 class="left">
                    <br>
                    <span class="display-1">Вход</span>
                </v-flex>
            </v-card-media>
            <v-card-title>
                <v-flex xs12>
                    <v-alert v-if="flagError" type="error" :value="true">
                        <ul v-if="arrErrors && arrErrors.length">
                            <li v-for="(index, key) of arrErrors">
                                {{arrErrors[key].key}}: {{arrErrors[key].val}}
                            </li>
                        </ul>
                        {{resultMessage}}
                    </v-alert>
                    <v-form ref="form" lazy-validation v-model="valid">
                        <v-text-field
                                name="email"
                                label="E-mail"
                                v-model="form.email"
                                :rules="emailRules"
                                :counter="255"
                                required></v-text-field>
                        <v-text-field
                                name="password"
                                label="Пароль"
                                :append-icon="e3 ? 'visibility' : 'visibility_off'"
                                :append-icon-cb="() => (e3 = !e3)"
                                :type="e3 ? 'password' : 'text'"
                                min="8"
                                v-model="form.password"
                                :rules="passwordRules"
                                :counter="255"
                                required></v-text-field>
                    </v-form>
                </v-flex>
            </v-card-title>
            <v-card-actions>
                <v-btn color="green darken-4" dark @click.stop="onSubmit">Войти</v-btn>
                <v-btn color="primary" flat @click.stop="close">Закрыть</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
    import {Form} from '../../form/Form.js'
    import {myLoginRoutine} from './myLoginRoutine';
    import { createNamespacedHelpers, mapActions } from 'vuex'
    const {mapState} = createNamespacedHelpers('auth')

    export default {
        props: { },
        data: function() {
            return {
                e3: true,
                login: false,
                valid: false,
                form: new Form({
                    email: '',
                    password: '',
                }),
                emailRules: [
                    v => !!v || 'E-mail обязательный для заполнения',
                    v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail должен иметь правильный формат'
                ],
                passwordRules: [
                    v => !!v || 'Пароль обязательный для заполнения',
                    v => v.length >=6 || 'Пароль должен иметь не менее 6 символов'
                ],
                flagError: false,
                arrErrors: [],
                resultMessage: ''
            }
        },
        mounted: function() {
        },
        computed: {
            ...mapState({
                active: state => state.active,
            })
        },
        methods: {
            ...mapActions('auth',[
                'disactive',
                'adminView',
                'admin'
            ]),
            close() {
                this.disactive();
                this.$refs.form.reset()
            },
            onSubmit() {
                let obj = this.form;
                /*axios.post('/login', {data: obj}).then(resp => {
                    console.log('work')
                }).catch(error => {
                    console.log('err')
                    let response = error.response;
                    if(response.status === 422) {
                        this.flagError = true
                        const errors = response.data.errors
                        for(var key in errors) {
                            errors[key].forEach(item => {
                                this.arrErrors.push({'key': key, 'val': item })
                            })
                        }
                        setTimeout(() => {
                            this.flagAlert = false
                            this.arrErrors = []
                        }, 4000);
                    }
                });*/
                /*this.form.submit('post','/login').then(resp => {
                    localStorage.setItem("isAdmin", "true")
                    this.admin()
                    this.adminView()
                    this.$router.push('admin')
                }).catch(error => {
                    let response = error.response;
                    console.log(response)
                    if(response.status === 422) {
                        this.flagError = true
                        const errors = response.data.errors
                        for(key in errors) {
                            errors[key].forEach(item => {
                                this.arrErrors.push({'key': key, 'val': item })
                            })
                        }
                        console.log(this.arrErrors)
                        setTimeout(() => this.flagAlert = false, 2000);
                    }
                })*/

                axios({url: '/login', data: obj, method: 'POST'}).then(resp => {
                    document.location.href="/"
                    //localStorage.setItem("isAdmin", "true")
                    //this.admin()
                    //this.adminView()
                    //this.$router.push('admin')
                }).catch(error => {
                    console.log('err')
                    let response = error.response;
                    if(response.status === 422) {
                        this.flagError = true
                        const errors = response.data.errors
                        for(var key in errors) {
                            errors[key].forEach(item => {
                                this.arrErrors.push({'key': key, 'val': item })
                            })
                        }
                        setTimeout(() => {
                            this.flagAlert = false
                            this.arrErrors = []
                        }, 4000);
                    }
                })
                /*axios.post('/login',{obj}).then((response) => {
                    localStorage.setItem("isAdmin", "true")
                    this.admin()
                    this.adminView()
                    this.$router.push('admin')
                }).catch(err => {
                    console.log(err)
                })*/
                /*myLoginRoutine(this.form).then(() => {
                    localStorage.setItem("isAdmin", "true")
                    this.admin()
                    this.adminView()
                    this.$router.push('admin')
                }).catch(err => {
                    console.log(err)
                })*/
                //this.$router.push('/admin');
                /*if(this.$refs.form.validate()) {
                    this.form.submit('post', '/login').then(data => {
                        this.$router.push('/admin');
                        this.login = false;
                    }).catch(errors => {
                        console.log(errors)
                    });
                }*/
            }
        }
     }
</script>