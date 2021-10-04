<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-pagelines"></i> Packages</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <router-link :to="{name: 'packages.create'}" class="btn btn-primary">Create</router-link>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <app-loader/>
                    <div class="tile-body" v-if="!isEmpty(packageData)">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Package Code</th>
                                <th>Name</th>
                                <th>Publish</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(packageS, index) in packageData.data">
                                <td>{{ packageS.id }}</td>
                                <td>{{ packageS.name }}</td>
                                <td>
                                    {{ packageS.publish_at || 'Unpublished' }}
                                </td>
                                <td>
                                    <router-link exact class="btn btn-primary btn-xs" :to="{ name: 'packages.update', params: { slug: packageS.slug } }">
                                        <i class="fa fa-pencil"></i>
                                    </router-link>
                                    <button class="btn btn-danger btn-xs" @click="willDelete(packageS.routes.destroy, () => packageData.data.splice(index, 1))">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <Paginator :data="packageData" @change-page="getPackages"></Paginator>
                    </div>
                </div>
            </div>
        </div>
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
                packageData: {}
            }
        },
        components: {
            Modal, ErrorMessage, Paginator
        },
        mounted(){
            this.getPackages()
        },
        methods: {
            getPackages(page = 1){
                window.axios.get(`/packages`, {
                    params: {
                        page
                    }
                }).then(({ data }) => {
                    this.packageData = data
                })
            }
        }
    }
</script>