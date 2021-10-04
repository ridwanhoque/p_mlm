<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-laptop"></i> Suppliers</h1>
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
                    <div class="tile-body" v-if="!isEmpty(supplierData)">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(supplier, index) in supplierData.data">
                                    <td>{{ supplier.name }}</td>
                                    <td>{{ supplier.phone_number }}</td>
                                    <td>{{ supplier.address }}</td>
                                    <td>
                                        <button @click="openEditModal(supplier)" class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button @click="willDelete(supplier.routes.destroy, () => supplierData.data.splice(index, 1))" class="btn btn-danger btn-xs">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Paginator :data="supplierData" @change-page="getSuppliers"></Paginator>
                    </div>
                </div>
            </div>
        </div>

        <Modal modal-class="create-modal" title="Create Supplier">
            <form @submit.prevent="create">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control" name="name" id="name" placeholder="Enter name here">
                    <ErrorMessage :errors="errors" error-key="name"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter phone number here">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea rows="4" class="form-control" name="address" id="address" placeholder="Enter address here"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Create</button>
                </div>
            </form>
        </Modal>

        <Modal modal-class="update-modal" title="Update Supplier">
            <form @submit.prevent="update" :action="supplier.routes.update" v-if="!isEmpty(supplier)">
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="edit-name">Name</label>
                    <input type="text" v-model="supplier.name" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control" name="name" id="edit-name" placeholder="Enter name here">
                    <ErrorMessage :errors="errors" error-key="name"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="edit-phone_number">Phone Number</label>
                    <input type="text" v-model="supplier.phone_number" class="form-control" name="phone_number" id="edit-phone_number" placeholder="Enter phone number here">
                </div>
                <div class="form-group">
                    <label for="edit-address">Address</label>
                    <textarea rows="4" class="form-control" v-model="supplier.address" name="address" id="edit-address" placeholder="Enter address here"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>
        </Modal>
    </div>
</template>

<script>
    import Modal from '../../components/modal'
    import ErrorMessage from '../../components/error-message'
    import Paginator from '../../components/paginator'

    export default {
        data(){
            return {
                errors: {},
                supplierData: {},
                supplier: {}
            }
        },
        components: {
            Modal, ErrorMessage, Paginator
        },
        mounted(){
            this.getSuppliers()
            this.$nextTick(() => {
                $('.create-modal, .update-modal').on('hide.bs.modal', () => {
                    this.errors = {}
                })
            })
        },
        methods: {
            create(e){
                window.axios.post('/suppliers', new FormData(e.target)).then(({ data }) => {
                    $('.create-modal').modal('hide')
                    this.getSuppliers()
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            },
            getSuppliers(page = 1){
                window.axios.get(`/suppliers`, {
                    params: {
                        page
                    }
                }).then(({ data }) => {
                    this.supplierData = data
                })
            },
            openEditModal(supplier){
                this.supplier = supplier
                $('.update-modal').modal()
            },
            update({ target }){
                window.axios.post(target.action, new FormData(target)).then(() => {
                    this.getSuppliers()
                    $('.update-modal').modal('hide')
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            }
        }
    }
</script>