<script>
    export default {
        props: [
            'paymentMethod'
        ],
        data(){
            return {
                payment_type: 'sslcommerz'
            }
        },
        mounted(){
            if(this.paymentMethod){
                this.payment_type = this.paymentMethod
            }
        },
    }
</script>