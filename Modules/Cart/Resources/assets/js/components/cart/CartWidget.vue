<template>
    <span>
       <a href="#" @click="$emit('showmodal')">{{cart.count}} товар(ов), {{coursePrice}} руб.</a>
    </span>
</template>
<script>
    export default {
        props: {
            cartItem: Object,
        },
        data: function() {
            return {
                cart: {
                    count: 0,
                    total: 0
                }
            }
        },
        created() {
            this.$eventBus.$on('change-count', this.changeCount);
            this.$eventBus.$on('change-total', this.changeTotal);
            this.$eventBus.$on('add-cart-qty', this.addCartQty);
            this.$eventBus.$on('add-cart-qty-one-click', this.addCartQtyOneClick);
            this.$eventBus.$on('update-qty', this.updateQty);
        },
        computed: {
            coursePrice: function() {
                //return window.course(this.cart.total);
                return this.cart.total;
            }
        },
        mounted() {
            this.cart = this.cartItem;
            let that = this;
            this.axios.get('/current-cart', {}).then(function (response) {
                if(response.data) {
                    let cartVal = response.data;
                    that.cart.count =  cartVal.count?cartVal.count:0;
                    that.cart.total = cartVal.total?cartVal.total:0;
                }
            }).catch(function (error)
            {
                console.log(error);
            });
        },
        methods: {
            changeCount(count) {
                this.cart.count = count;
            },
            changeTotal(total) {
                this.cart.total = total;
            },
            addCartQty(id,qty) {
                let that = this;
                this.axios.post('/add-cart', {id: id, qty: qty}).then(function (response) {
                    let cartVal = response.data;
                    that.cart.count =  cartVal.count;
                    that.cart.total = cartVal.total;

                }).catch(function (error)
                {
                    console.log(error);
                });
            },
            addCartQtyOneClick(id,qty) {
                let that = this;
                this.axios.post('/add-cart', {id: id, qty: qty}).then(function (response) {
                    let cartVal = response.data;
                    that.cart.count =  cartVal.count;
                    that.cart.total = cartVal.total;
                    window.location = "/order.php";
                }).catch(function (error)
                {
                    console.log(error);
                });
            },
            upQty(id) {
                let qty = 1;
                let that = this;
                this.axios.get('/cart-up-qty/'+id+'/'+qty, {}).then(function (response) {
                    this.cart.count = this.cart.count + 1;
                }).catch(function (error)
                {
                    console.log(error);
                });
            },
            /*downQty(id) {
                let qty = 1;
                let that = this;
                this.axios.get('/cart-down-qty/'+id+'/'+qty, {}).then(function (response) {
                    this.cart.count = this.cart.count - 1;
                }).catch(function (error)
                {
                    console.log(error);
                });
            },
            updateQty(id, qty) {
                let that = this;
                this.axios.get('/update-qty/'+id+'/'+qty, {}).then(function (response) {
                    that.cart.count = that.cart.count + qty;
                }).catch(function (error)
                {
                    console.log(error);
                });
            }*/
        }
    }
</script>
<style>
    [v-cloak] {
        display: none;
        width: 10px;
    }
</style>