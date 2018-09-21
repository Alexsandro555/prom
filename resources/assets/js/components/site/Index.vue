<template>
    <v-app>
        <template>
            <v-layout column wrap>
                <v-container fluid grid-list-xs text-xs-center>
                    <leader-header></leader-header>
                    <leader-footer></leader-footer>
                </v-container>
            </v-layout>
        </template>
    </v-app>
</template>
<script>
    import LeaderHeader from './leader-header'
    import LeaderFooter from "./leader-footer";

    export default {
        components: {
            LeaderFooter,
            LeaderHeader},
        props: { },
        data: function() {
            return { }
        },
        mounted: function() {
        },
        component: {
            'leader-header': LeaderHeader,
            'leader-footer': LeaderFooter
        },
        methods: {
        }
     }
</script>