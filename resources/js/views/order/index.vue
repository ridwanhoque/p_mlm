<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-car"></i> Orders</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <app-loader/>
                    <div class="tile-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Owner Name</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Optons</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(order, index) in orderData.data">
                                    <td>{{ order.id }}</td>
                                    <td>{{ order.user.name }}</td>
                                    <td>{{ order.total.formatted() }}</td>
                                    <td>
                                        <Status @updated="getOrders" :status="order.status.raw" :url="order.routes.statusUpdate"></Status>
                                    </td>
                                    <td>
                                        <router-link class="btn btn-xs btn-primary" :to="{ name: 'order.show', params: {order: order.id}}">
                                            <i class="fa fa-eye"></i>
                                        </router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Paginator :data="orderData" @change-page="getOrders"></Paginator>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Paginator from '../../components/paginator'
    import Order from "../../services/Order";
    import Status from '../../components/status'

    export default {
        data(){
            return {
                errors: {},
                orderData: {
                    data: []
                }
            }
        },
        components: {
            Paginator, Status
        },
        mounted(){
            this.getOrders()
        },
        methods: {
            getOrders(page = 1){
                Order.get({page}).then(( { data }) => {
                    this.orderData = data
                });
            }
        }
    }
</script>