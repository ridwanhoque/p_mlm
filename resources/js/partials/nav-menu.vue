<template>
    <div>
        <!-- Sidebar menu-->
        <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
        <aside class="app-sidebar">
            <div class="app-sidebar__user" v-if="$store.getters.isAuthenticated">
                <img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
                <div>
                    <p class="app-sidebar__user-name">{{ $store.getters.fullName }}</p>
                </div>
            </div>
            <ul class="app-menu">
                <li>
                    <router-link exact :to="{ name:'home.index' }" class="app-menu__item">
                        <i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span>
                    </router-link>
                </li>
                <li>
                    <a class="app-menu__item" target="_blank" href="/">
                        <i class="app-menu__icon fa fa-eye"></i><span class="app-menu__label">Visit Site</span>
                    </a>
                </li>
                <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Products</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                    <ul class="treeview-menu">
                        <li>
                            <router-link class="treeview-item" :to="{name: 'brands.index'}">
                                <i class="icon fa fa-circle-o"></i> Brands
                            </router-link>
                        </li>
                        <li>
                            <router-link class="treeview-item" :to="{name: 'suppliers.index'}">
                                <i class="icon fa fa-circle-o"></i> Suppliers
                            </router-link>
                        </li>
                        <li>
                            <router-link class="treeview-item" :to="{name: 'products.index'}">
                                <i class="icon fa fa-circle-o"></i> Products
                            </router-link>
                        </li>
                        <li>
                            <router-link class="treeview-item" :to="{name: 'categories.index'}">
                                <i class="icon fa fa-circle-o"></i> Categories
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li>
                    <router-link :to="{ name:'packages.index' }" class="app-menu__item">
                        <i class="app-menu__icon fa fa-pagelines"></i><span class="app-menu__label">Package</span>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name:'courses.index' }" class="app-menu__item">
                        <i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">Course</span>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name:'order.index' }" class="app-menu__item">
                        <i class="app-menu__icon fa fa-car"></i><span class="app-menu__label">Order</span>
                    </router-link>
                </li>
                <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-ambulance"></i><span class="app-menu__label">Delivery</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                    <ul class="treeview-menu">
                        <li>
                            <router-link class="treeview-item" :to="{ name: 'delivery.center.index' }">
                                <i class="icon fa fa-circle-o"></i> Center
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-shopping-cart"></i><span class="app-menu__label">Inventory</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                    <ul class="treeview-menu">
                        <li>
                            <router-link class="treeview-item" :to="{ name: 'inventory.purchase' }">
                                <i class="icon fa fa-circle-o"></i> Purchase
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a class="app-menu__item" href="#" data-toggle="treeview">
                        <i class="app-menu__icon fa fa-calculator"></i><span class="app-menu__label">Commission</span><i class="treeview-indicator fa fa-angle-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <router-link class="treeview-item" :to="{ name: 'commission.hand.index' }">
                                <i class="icon fa fa-circle-o"></i> Commission Hand
                            </router-link>
                        </li>
                        <li>
                            <router-link class="treeview-item" :to="{ name: 'commission.bonus.index' }">
                                <i class="icon fa fa-circle-o"></i> Bonus
                            </router-link>
                        </li>
                        <li>
                            <router-link class="treeview-item" :to="{ name: 'commission.configuration' }">
                                <i class="icon fa fa-circle-o"></i> Configuration
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a class="app-menu__item" href="#" data-toggle="treeview">
                        <i class="app-menu__icon fa fa-cc"></i>
                        <span class="app-menu__label">Promotional</span><i class="treeview-indicator fa fa-angle-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <router-link class="treeview-item" :to="{ name: 'promotional.designation.index' }">
                                <i class="icon fa fa-circle-o"></i> Designation
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a class="app-menu__item" href="#" data-toggle="treeview">
                        <i class="app-menu__icon fa fa-usd"></i>
                        <span class="app-menu__label">Wallet Option</span><i class="treeview-indicator fa fa-angle-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <router-link class="treeview-item" :to="{ name: 'wallet.payments.index' }">
                                <i class="icon fa fa-circle-o"></i> Payments
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li>
                    <router-link :to="{ name:'site-option.index' }" class="app-menu__item">
                        <i class="app-menu__icon fa fa-cogs"></i><span class="app-menu__label">Site Option</span>
                    </router-link>
                </li>
                <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Users</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                    <ul class="treeview-menu">
                        <li>
                            <router-link class="treeview-item" :to="{ name: 'user.references' }">
                                <i class="icon fa fa-circle-o"></i> Reference
                            </router-link>
                        </li>
                    </ul>
                </li>

                <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Web Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                    <ul class="treeview-menu">
                        <li>
                            <router-link class="treeview-item" :to="{ name: 'web.slider.index' }">
                                <i class="icon fa fa-circle-o"></i> Slider
                            </router-link>
                        </li>
                    </ul>
                </li>
            </ul>
        </aside>
    </div>
</template>

<script>
    import { Bus } from "../helper";

    export default {
        mounted() {
            Bus.$on('user-loaded', () => {
                this.bootNavigation()
            })
        },
        methods: {
            bootNavigation(){
                this.$nextTick(() => {
                    let treeviewMenu = $('.app-menu');

                    // Toggle Sidebar
                    $('[data-toggle="sidebar"]').click(function(event) {
                        event.preventDefault();
                        $('.app').toggleClass('sidenav-toggled');
                    });

                    // Activate sidebar treeview toggle
                    $("[data-toggle='treeview']").click(function(event) {
                        event.preventDefault();
                        if(!$(this).parent().hasClass('is-expanded')) {
                            treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
                        }
                        $(this).parent().toggleClass('is-expanded');
                    });

                    // Set initial active toggle
                    $("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');
                })
            }
        }
    }
</script>