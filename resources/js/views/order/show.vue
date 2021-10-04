<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-car"></i> Order #{{ $route.params.order }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <app-loader/>
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h2>{{ order.user.name }}</h2>
                            </div>
                            <div class="col-md-8">
                                <h4>Order Items</h4>
                                <table class="table-striped table table-hover table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Commission</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in items">
                                            <td>{{ item.item.name }}</td>
                                            <td>{{ item.quantity }}</td>
                                            <td>{{ item.price }}</td>
                                            <td>{{ item.commission }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Status from '../../components/status'

    export default {
        data(){
            return {
                errors: {},
                order: {
                    user: {}
                },
                items: []
            }
        },
        components: {
            Status
        },
        mounted(){
            window.axios.get(`/orders/${this.$route.params.order}`).then(({ data }) => {
                this.order = data.data;
                this.items = data.items;
            })
        },

    }
</script>