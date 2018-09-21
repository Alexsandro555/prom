<template>
    <div>
        <div v-if="username">
            <a class="login-widget" href="/admin">{{username}}</a>
        </div>
        <div v-else>
            <a class="login-widget" @click.stop="onLogin" href="#">Войти</a> |
            <a class="login-widget" @click.stop="registration">Регистрация</a>
        </div>
    </div>
</template>
<script>
    export default {
        props: { },
        data: function() {
            return {
                username: null
            }
        },
        mounted() {
            axios.get('/authenticated').then((response) => {
                this.username = response.data
            }).catch(err => {
                console.log(err)
            })
        },
        methods: {
            onLogin() {
                this.$store.dispatch('auth/active')
            },
            onAdmin() {
                this.$store.dispatch('auth/adminView')
                this.$router.push('admin')
            },
            registration() {
                this.$store.dispatch('auth/registration')
            }
        }
     }
</script>

<style>
    .login-widget {
        text-decoration: none;
        color: white;
    }
</style>