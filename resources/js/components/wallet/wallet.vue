<template>
    <div>
        <button @click="isOpen = true" type="button" class="btn btn-primary btn-xs">{{ source }}</button>
        <component :payment="payment" :source="source" @modalClose="isOpen = false" :is="componentName" v-if="isOpen"></component>
    </div>
</template>

<script>

    import SSLCommerz from './sslcommerz'
    import Bank from './bank'
    import Order from './order'

    export default {
        props: {
            source: {
                type: String,
                default: ''
            },
            id: [String, Number]
        },
        components: {
            sslcommerz: SSLCommerz,
            bank: Bank,
            order: Order
        },
        data(){
            return {
                isOpen: false,
                payment: {}
            }
        },
        computed: {
            componentName(){
                return this.source.toLocaleLowerCase().replace(' ', '');
            }
        },
        watch: {
            isOpen(value){
                if(value){
                    window.axios.get(`/wallets/${this.id}`).then(({ data }) => {
                        this.payment = data.data
                    })
                }

                if(!value){
                    this.payment = {}
                }
            }
        }
    }
</script>