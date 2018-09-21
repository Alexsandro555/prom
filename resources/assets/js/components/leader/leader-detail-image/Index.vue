<template>
    <v-flex xs5 class="detail__image">
        <v-container fluid grid-list-md>
            <v-layout column align-center wrap>
                <div class="detail__image-big">
                    <div class="detail-images-center">
                        <div class="img-shadow">
                            <img v-if="curImage" class="text-xs-center" :src="curImage" />
                            <img v-else src="/images/no-image.png" class="text-xs-center" width="200px"/>
                        </div>
                    </div>
                </div>
                <div>
                    &nbsp;
                    <carousel style="width: 280px" v-if="items.length>0"
                              name="carousel4"
                              :pagination-enabled=false
                              :navigation-enabled=true
                              :per-page=3
                              :per-page-custom="[[480, 3]]">
                        <slide class="outer-carousel-slide" v-for="item in items" :key="item.id">
                            <div class="carousel-slide" @click="selectSlide(item.id)">
                                <img :src="'/storage/'+item.file"/>
                            </div>
                        </slide>
                    </carousel>
                </div>
            </v-layout>
        </v-container>
    </v-flex>
</template>
<script>
    import { Carousel, Slide } from 'vue-carousel';

    export default {
        props: {
            url: String,
        },
        data: function() {
            return {
                elements:[],
                items:[],
                curImage: '',
            }
        },
        mounted() {
            axios.get(this.url).then(response =>
            {
                this.elements = response.data
                response.data.forEach(element => {
                    this.items.push({'id': element.id, 'file': element.config.files.small.filename});
                });
                this.curImage = this.items.length>0?'/storage/' + this.elements[0].config.files.main.filename:null
            }).catch(error => { console.log(error); });
        },
        components: {
            Carousel,
            Slide
        },
        methods: {
            selectSlide: function (id, event) {
                this.elements.forEach(element => {
                    if(element.id === id) {
                        this.curImage = '/storage/'+element.config.files.main.filename;
                    }
                });
            }
        }
    }
</script>

<style>
    .detail__image {
        display: block;
    }

    .detail__image-big {
        display: block;
        float: left;
        width: 306px;
        //height: 259px;
        background-color: white;
    }

    .detail-images-center {
        margin: 5px;
        display: inline-block;
        vertical-align: middle;
        text-align: center;
        height: 239px;
        line-height: 239px;
    }

    /* Добавление размытия по-краям */
    .img-shadow {
        position: relative;
        max-width: 100%;
        float: left;
        display: inline-block;
        vertical-align: middle;
        line-height: 1.25; /* переопределить высоту строки на обычную */
    }

    .img-shadow::before {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        box-shadow: 0 0 2px 2px white inset;
        -moz-box-shadow: 0 0 2px 2px white inset;
        -webkit-box-shadow: 0 0 2px 2px white inset;
    }

    .img-shadow img {
        float: left;

    }
    /* Конец добавления размытия по-краям */

    .outer-carousel-slide {
        line-height: 90px;
    }

    .carousel-slide {
        display: inline-block; /* центрировать..*/
        vertical-align: middle;  /* ..по вертикали */
        line-height: 1.25; /* переопределить высоту строки на обычную */
    }
</style>