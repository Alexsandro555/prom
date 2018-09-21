<template>
    <v-dialog v-model="openRegistration" max-width="500px" class="text-xs-center">
        <v-card>
            <v-card-media dark height="100px" class="register-head">
                <v-flex xs11 offset-xs1 class="left">
                    <br>
                    <span class="display-1">Регистрация</span>
                </v-flex>
            </v-card-media>
            <v-card-title>
                <v-flex xs12>
                    <v-form ref="form" lazy-validation v-model="valid">
                        <v-text-field
                                name="name"
                                label="Имя"
                                v-model="form.name"
                                :rules="nameRules"
                                :counter="255"
                                required></v-text-field>
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
                        <v-text-field
                                name="password-confirm"
                                label="Подтверждение пароля"
                                :append-icon="e3 ? 'visibility' : 'visibility_off'"
                                :append-icon-cb="() => (e3 = !e3)"
                                :type="e3 ? 'password' : 'text'"
                                min="8"
                                v-model="form.confirm"
                                :rules="confirmRules"
                                :counter="255"
                                required></v-text-field>
                    </v-form>
                </v-flex>
            </v-card-title>
            <v-card-actions>
                <v-btn color="green darken-4" dark @click.stop="register">Зарегистрироваться</v-btn>
                <v-btn color="primary" flat @click.stop="close">Закрыть</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
    import {Form} from '../../form/Form.js'
    import { createNamespacedHelpers, mapActions } from 'vuex'
    const {mapState} = createNamespacedHelpers('auth')
    export default {
        props: { },
        data: function() {
            return {
                valid: false,
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    confirm: ''
                }),
                nameRules: [
                    v => !!v || 'Обязательно для заполнения',
                    v => v.length <= 255 || 'Длина не должна превышать 255 символов'
                ],
                emailRules: [
                    v => !!v || 'E-mail обязательный для заполнения',
                    v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail должен иметь правильный формат'
                ],
                passwordRules: [
                    v => !!v || 'Пароль обязательный для заполнения',
                    v => v.length >=6 || 'Пароль должен иметь не менее 6 символов'
                ],
                confirmRules: [
                  v => !!v || 'Обязательно для заполнения',
                  v => v == this.form.password || 'Пароли не совпадают'
                ],
                e3: true
            }
        },
        computed: {
            ...mapState({
                openRegistration: state => state.openRegistration,
            })
        },
        mounted: function() {
        },
        methods: {
            ...mapActions('auth',[
                'registration',
                'disableRegistration'
            ]),
            register() {
                if(this.$refs.form.validate()) {
                    this.form.submit('post', '/register').then(data => {
                        this.disableRegistration();
                    }).catch(errors => {
                        console.log(errors)
                    });
                }
            },
            close() {
                this.disableRegistration();
            }
        }
     }
</script>
<style>
    .register-head {
        background-color: #1B5E20;
        color: white;
    }
</style>