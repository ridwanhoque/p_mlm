<template>
    <div>
        <!-- Navbar-->
        <header class="app-header"><a class="app-header__logo" href="/">MLM</a>
            <!-- Sidebar toggle button-->
            <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
            <!-- Navbar Right Menu-->
            <ul class="app-nav">
                <!-- User Menu-->
                <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                    <ul class="dropdown-menu settings-menu dropdown-menu-right">
                        <li><a class="dropdown-item" @click.prevent="logout" href="#"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </header>
        <NavMenu/>

        <main class="app-content">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
    import NavMenu from '../../partials/nav-menu'
    import { Bus } from "../../helper";

    export default {
        components: {
            NavMenu
        },
        created() {
            axios.get('/user').then(({ data }) => {
                this.$store.commit('setAuthUser', data.data)
            }).then(() => {
                Bus.$emit('user-loaded')
            })
        },
        methods: {
            logout(){
                window.axios.post(`${location.origin}/logout`).then(() => location.reload())
            }
        }
    }
</script>

<style lang="scss">
    .table th, .table td{
        vertical-align: middle;
        padding: 0.55rem 0.75rem;
    }

    .btn.btn-xs{
        padding: 0.15rem 0.35rem;
        font-size: 8px;
    }
</style>