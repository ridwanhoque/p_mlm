<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-laptop"></i> Brands</h1>
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
                    <div class="tile-body" v-if="!isEmpty(brandData)">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(brand, index) in brandData.data">
                                    <td>
                                        <img width="120" :src="brand.logo" class="img-fluid" alt="">
                                    </td>
                                    <td>{{ brand.name }}</td>
                                    <td>
                                        <button @click="openUpdateModal(brand)" class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button @click="willDelete(brand.routes.destroy, () => brandData.data.splice(index, 1))" class="btn btn-danger btn-xs">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Paginator :data="brandData" @change-page="getBrands"></Paginator>
                    </div>
                </div>
            </div>
        </div>

        <Modal modal-class="create-modal" title="Create Brand">
            <form @submit.prevent="create">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control" name="name" id="name" placeholder="Enter name here">
                    <ErrorMessage :errors="errors" error-key="name"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="logo">Logo</label>
                    <input type="file" :class="{'is-invalid': errors.hasOwnProperty('logo')}" class="form-control" name="logo" id="logo">
                    <ErrorMessage :errors="errors" error-key="logo"></ErrorMessage>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Create</button>
                </div>
            </form>
        </Modal>

        <Modal modal-class="update-modal" title="Update Brand">
            <form @submit.prevent="update" :action="brand.routes.update" v-if="!isEmpty(brand)">
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" v-model="brand.name" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control" name="name" id="name" placeholder="Enter name here">
                    <ErrorMessage :errors="errors" error-key="name"></ErrorMessage>
                </div>
                <img :src="brand.logo" class="img-thumbnail" alt="">
                <div class="form-group">
                    <label for="logo">Logo</label>
                    <input type="file" :class="{'is-invalid': errors.hasOwnProperty('logo')}" class="form-control" name="logo" id="logo">
                    <ErrorMessage :errors="errors" error-key="logo"></ErrorMessage>
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
                brandData: {},
                brand: {}
            }
        },
        components: {
            Modal, ErrorMessage, Paginator
        },
        mounted(){
            this.getBrands()
            $('.create-modal, .update-modal').on('modal.bs.hide', () => {
                this.errors = {}
            })
        },
        methods: {
            create(e){
                window.axios.post('/brands', new FormData(e.target)).then(({ data }) => {
                    $('.create-modal').modal('hide')
                    this.getBrands()
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            },
            getBrands(page = 1){
                window.axios.get(`/brands`, {
                    params: {
                        page
                    }
                }).then(({ data }) => {
                    this.brandData = data
                })
            },
            openUpdateModal(brand){
                $('.update-modal').modal();
                this.brand = brand
            },
            update({ target }){
                window.axios.post(target.action, new FormData(target)).then(({ data }) => {
                    this.getBrands()
                    $('.update-modal').modal('hide');
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            }
        }
    }
</script>