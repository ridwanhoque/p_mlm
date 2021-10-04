<template>
    <div>
        <div class="app-title">
            <div>
                <h1>{{ reference.name }}</h1>
                <p>Stage: {{ reference.designation.stage }}</p>
                <p>Designation: {{ reference.designation.name }}</p>
                <p>Members: {{ reference.members }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <app-loader/>
                    <h3 class="tile-title">Designations</h3>
                    <div class="tile-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Designation</th>
                                    <th>Stage</th>
                                    <th>Members</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(designation, index) in designations">
                                    <td>{{ index + 1 }}</td>
                                    <td>
                                        <router-link :to="{ name: 'user.references', params: { user: $route.params.user}, query: { designation: designation.id }}">{{ designation.name }}</router-link>
                                    </td>
                                    <td>{{ designation.stage }}</td>
                                    <td>{{ designation.users_count }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tile" v-if="designationUsers.length">
                    <app-loader/>
                    <h3 class="tile-title">Users</h3>
                    <div class="tile-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>RM</th>
                                    <th>URM</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, index) in designationUsers">
                                    <td>{{ index + 1 }}</td>
                                    <td>
                                        <router-link :to="{ name: 'user.references', params: { user: user.id }}">{{ user.name }}</router-link>
                                    </td>
                                    <td>
                                        {{ user.designation.name }}
                                    </td>
                                    <td>{{ user.members.register }}</td>
                                    <td>{{ user.members.unregister }}</td>
                                    <td>{{ user.members.total }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data(){
            return {
                reference: {
                    designation: {}
                },
                designations: [],
                designationUsers: []
            }
        },
        mounted(){
            this.getUser(this.$route.params.user || '').then(() => {
                if(this.$route.query.designation){

                    this.getDesignationUser(this.$route.query.designation)
                }
            })
        },
        methods: {
            getUser(user = ''){
                return window.axios.get(`/users/${user}`).then(({ data }) => {
                    this.reference = data.data;
                    this.designations = data.designations
                })
            },
            getDesignationUser(designation){
                window.axios.get(`/promotional-designations/${designation}/${this.reference.id}`).then(({ data }) => {

                    this.designationUsers = data.data;
                })
            }
        },
        watch: {
            $route(to, from){
                if(to.query.designation){
                    this.getDesignationUser(to.query.designation)
                }else{
                    this.designationUsers = []
                }

                this.getUser(to.params.user)
            }
        }
    }
</script>