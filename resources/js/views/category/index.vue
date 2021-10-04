<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-laptop"></i> {{ isEmpty(rootCategory) ? 'Categories' : `Subcategory of ${ rootCategory.name }` }} </h1>
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
                    <div class="tile-body" v-if="!isEmpty(categoryData)">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Child's</th>
                                    <th>Is Featured</th>
                                    <th>Show On HomePage</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(category, index) in categoryData.data">
                                    <td>
                                        <img width="100px" :src="category.image" alt="Image">
                                    </td>
                                    <td>{{ category.name }}</td>
                                    <td>
                                        <router-link @click="getCategories" class="btn btn-sm btn-primary" exact :to="{ name: 'categories.index', query: { parent_id: category.id } }">Subcategories</router-link>
                                    </td>
                                    <td>{{ category.is_featured ? 'Yes' : 'No' }}</td>
                                    <td>{{ category.show_on_home ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <button @click="openUpdateModal(category)" class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button @click="willDelete(category.routes.destroy, () => categoryData.data.splice(index, 1))" class="btn btn-xs btn-danger">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="!categoryData.data.length">
                                    <td colspan="6" class="text-center">There are no categories found!</td>
                                </tr>
                            </tbody>
                        </table>
                        <Paginator :data="categoryData" @change-page="getCategories"></Paginator>
                    </div>
                </div>
            </div>
        </div>

        <Modal modal-class="create-modal" title="Create Category">
            <form @submit.prevent="create">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control" name="name" id="name" placeholder="Enter name here">
                    <ErrorMessage :errors="errors" error-key="name"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" :class="{'is-invalid': errors.hasOwnProperty('image')}" class="form-control form-control-sm" name="image" id="image">
                    <ErrorMessage :errors="errors" error-key="image"></ErrorMessage>
                    <small class="text-muted">Image size (300x300)px</small>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input name="is_featured" value="1" type="checkbox" class="custom-control-input" id="is-featured">
                        <label class="custom-control-label" for="is-featured">Is Featured</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input name="show_on_home" value="1" type="checkbox" class="custom-control-input" id="show-on-home">
                        <label class="custom-control-label" for="show-on-home">Show On Homepage</label>
                    </div>
                </div>
                <input v-if="!isEmpty(rootCategory)" type="hidden" name="parent_id" :value="rootCategory.id">
                <div class="form-group">
                    <button class="btn btn-primary">Create</button>
                </div>
            </form>
        </Modal>

        <Modal modal-class="update-modal" title="Update Category">
            <form :action="category.routes.update" @submit.prevent="update" v-if="!isEmpty(category)">
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="edit-name">Name</label>
                    <input type="text" :value="category.name" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control" name="name" id="edit-name" placeholder="Enter name here">
                    <ErrorMessage :errors="errors" error-key="name"></ErrorMessage>
                </div>
                <div class="form-group">
                    <div>
                        <img :src="category.image" class="img-thumbnail"  alt="Image">
                    </div>
                    <label for="edit-image">Image</label>
                    <input type="file" :class="{'is-invalid': errors.hasOwnProperty('image')}" class="form-control form-control-sm" name="image" id="edit-image">
                    <ErrorMessage :errors="errors" error-key="image"></ErrorMessage>
                    <small class="text-muted">Image size (300x300)px</small>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input name="is_featured" v-model="category.is_featured" value="1" type="checkbox" class="custom-control-input" id="edit-is-featured">
                        <label class="custom-control-label" for="edit-is-featured">Is Featured</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input name="show_on_home" v-model="category.show_on_home" value="1" type="checkbox" class="custom-control-input" id="edit-show-on-home">
                        <label class="custom-control-label" for="edit-show-on-home">Show On Homepage</label>
                    </div>
                </div>
                <input v-if="category.parent_id" type="hidden" name="parent_id" :value="category.parent_id">
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
                rootCategory: {},
                errors: {},
                categoryData: {},
                category: {}
            }
        },
        components: {
            Modal, ErrorMessage, Paginator
        },
        mounted(){
            this.getCategories()
            if(this.$route.query.hasOwnProperty('parent_id')){

                this.getRootCategory(this.$route)
            }
            this.$nextTick(() => {
                $('.create-modal, .update-modal').on('hide.bs.modal', () => {
                    this.errors = {}
                })
            })
        },
        methods: {
            create(e){
                window.axios.post('/categories', new FormData(e.target)).then(({ data }) => {
                    $('.create-modal').modal('hide')
                    e.target.reset()
                    this.getCategories()
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            },
            getCategories(page = 1){
                window.axios.get(`/categories`, {
                    params: {
                        page,
                        ...this.$route.query
                    }
                }).then(({ data }) => {
                    this.categoryData = data
                })
            },
            getRootCategory(targetRoute){
                window.axios.get(`/categories/${targetRoute.query.parent_id}`).then(({ data }) => {
                    this.rootCategory = data.data
                })
            },
            openUpdateModal(category){
                $('.update-modal').modal()
                this.category = category
            },
            update({ target }){
                window.axios.post(target.action, new FormData(target)).then(() => {
                    $('.update-modal').modal('hide')
                    this.getCategories();
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            }
        },
        watch: {
            $route(to, from){
                this.getCategories()
                if(to.query.hasOwnProperty('parent_id')){
                    this.getRootCategory(to)
                }else{
                    this.rootCategory = {}
                }
            }
        }
    }
</script>