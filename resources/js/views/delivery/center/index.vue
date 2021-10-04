<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-laptop"></i> Delivery Center</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <button data-toggle="modal" data-target=".create-modal" class="btn btn-primary">Create</button>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <app-loader/>
                    <div class="tile-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(deliveryCenter, index) in deliveryCenters">
                                <td>{{ deliveryCenter.name }}</td>
                                <td>{{ deliveryCenter.address }}</td>
                                <td>
                                    <button @click="openUpdateModal(deliveryCenter)" class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button @click="willDelete(deliveryCenter.routes.destroy, () => deliveryCenters.splice(index, 1))" class="btn btn-danger btn-xs">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <Modal modal-class="create-modal" title="Create Delivery Center">
            <form @submit.prevent="create">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control" name="name" id="name" placeholder="Enter name here">
                    <ErrorMessage :errors="errors" error-key="name"></ErrorMessage>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea :class="{'is-invalid': errors.hasOwnProperty('address')}"  rows="4" class="form-control" name="address" id="address" placeholder="Enter address here"></textarea>
                    <ErrorMessage :errors="errors" error-key="address"></ErrorMessage>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Create</button>
                </div>
            </form>
        </Modal>
        <Modal modal-class="update-modal" title="Update Slide">
            <form @submit.prevent="update" :action="deliveryCenter.routes.update" v-if="!isEmpty(deliveryCenter)">
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="edit-name">Name</label>
                    <input type="text" v-model="deliveryCenter.name" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control" name="name" id="edit-name" placeholder="Enter name here">
                    <ErrorMessage :errors="errors" error-key="name"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="edit-address">Address</label>
                    <textarea v-model="deliveryCenter.address" :class="{'is-invalid': errors.hasOwnProperty('address')}"  rows="4" class="form-control" name="address" id="edit-address" placeholder="Enter address here"></textarea>
                    <ErrorMessage :errors="errors" error-key="address"></ErrorMessage>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>
        </Modal>
    </div>
</template>

<script>
    import Modal from '../../../components/modal'
    import ErrorMessage from '../../../components/error-message'

    export default {
        data(){
            return {
                errors: {},
                deliveryCenters: [],
                deliveryCenter: {}
            }
        },
        components: {
            Modal, ErrorMessage
        },
        mounted(){
            this.getDeliveryCenters()

            this.$nextTick(() => {

                $('.create-modal, .update-modal').on('hide.bs.modal', () => {
                    this.errors = {}
                })
            })
        },
        methods: {
            create({ target }){
                window.axios.post('/delivery-centers', new FormData(target)).then(() => {
                    $('.create-modal').modal('hide')
                    this.getDeliveryCenters()
                    target.reset()
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            },
            getDeliveryCenters(){
                window.axios.get(`/delivery-centers`).then(({ data }) => {
                    this.deliveryCenters = data.data
                })
            },
            openUpdateModal(deliveryCenter){
                this.deliveryCenter = deliveryCenter
                $('.update-modal').modal()
            },
            update({ target }){
                axios.post(target.action, new FormData(target)).then(() => {
                    this.getDeliveryCenters()
                    $('.update-modal').modal('hide')
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            }
        }
    }
</script>