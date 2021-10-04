<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-gbp"></i> Purchase Payment History <strong>#{{ purchaseId }}</strong></h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <button data-toggle="modal" data-target=".payment-modal" class="btn btn-primary">Payment</button>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <app-loader></app-loader>
                        <table class="table-bordered table">
                            <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Amount</th>
                                <th>Creator</th>
                                <th>Created At</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="payment in payments">
                                    <td>{{ payment.id }}</td>
                                    <td>{{ payment.amount.formatted() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <Modal modal-class="payment-modal" title="Payment">
            <form @submit.prevent="create">
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('amount')}" id="amount" name="amount" class="form-control">
                    <ErrorMessage error-key="amount" :errors="errors"/>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Payment</button>
                </div>
            </form>
        </Modal>
    </div>
</template>

<script>
    import ErrorMessage from '../../../../components/error-message'
    import VueSelect from 'vue-select'
    import Modal from '../../../../components/modal.vue'
    import PurchasePayment from "../../../../services/PurchasePayment";

    export default {
        data(){
            return {
                errors: {},
                payments: [],
                purchase: {}
            }
        },
        computed: {
           purchaseId(){
               return this.$route.params.purchase
           }
        },
        components: {
            ErrorMessage, VueSelect, Modal
        },
        mounted(){
            this.getPayments()
        },
        methods: {
            create({ target }){
                PurchasePayment.store(this.purchaseId, target).then(() => {
                    this.getPayments()
                    this.errors = {}
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            },
            getPayments(){
                PurchasePayment.get(this.purchaseId).then(({ data }) => {
                    this.payments = data.data;
                    this.purchase = data.purchase;
                }).catch(({ response}) => {
                    this.$router.push({ name: 'inventory.purchase'})
                })
            }
        }
    }
</script>