import Vue from 'vue'
import VueRouter from 'vue-router'



Vue.use(VueRouter)


const routes = [
    {
        path: '/',
        name: 'home.index',
        component: require('./views/home/index').default
    },
    // Product Brand
    {
        name: 'brands.index',
        path:'/brands',
        component: require('./views/brand/index').default
    },
    // Supplier
    {
        name: 'suppliers.index',
        path:'/suppliers',
        component: require('./views/supplier/index').default
    },
    // Product
    {
        name: 'products.index',
        path:'/products',
        component: require('./views/product/index').default
    },
    {
        name: 'products.create',
        path:'/products/create',
        component: require('./views/product/create').default
    },
    {
        name: 'products.update',
        path:'/products/:slug/edit',
        component: require('./views/product/edit').default
    },
    // Category
    {
        name: 'categories.index',
        path:'/categories',
        component: require('./views/category/index').default
    },
    // Packages
    {
        name: 'packages.index',
        path:'/packages',
        component: require('./views/package/index').default
    },
    {
        name: 'packages.create',
        path:'/packages/create',
        component: require('./views/package/create').default
    },
    {
        name: 'packages.update',
        path:'/packages/:slug/edit',
        component: require('./views/package/edit').default
    },
    // Courses
    {
        name: 'courses.index',
        path:'/courses',
        component: require('./views/course/index').default
    },
    {
        name: 'courses.create',
        path:'/courses/create',
        component: require('./views/course/create').default
    },
    {
        name: 'courses.update',
        path:'/courses/:slug/edit',
        component: require('./views/course/edit').default
    },
    // // Emi Plan
    // {
    //     name: 'emi-plans.index',
    //     path:'/emi-plans',
    //     component: require('./views/emi-plan/index' /*webpackChunkName: "emi-plan"*/).default
    // },
    // Inventory
    {
        name: 'inventory.purchase',
        path:'/inventory/purchase',
        component: require('./views/inventory/purchase').default
    },
    {
        name: 'purchase.payment.index',
        path:'/purchase/:purchase/payments',
        component: require('./views/inventory/purchase/payment/index').default
    },
    // Commission
    {
        name: 'commission.hand.index',
        path:'/commissions/hands',
        component: require('./views/commission/hand/index').default
    },
    {
        name: 'commission.bonus.index',
        path:'/commissions/bonus',
        component: require('./views/commission/bonus/index').default
    },
    {
        name: 'commission.configuration',
        path:'/commissions/configuration',
        component: require('./views/commission/configuration').default
    },
    // Promotional Designation
    {
        name: 'promotional.designation.index',
        path:'/promotional/designations',
        component: require('./views/promotional/desgination/index').default
    },
    {
        name: 'user.references',
        path: '/users/references/:user?',
        component: require('./views/user/reference').default
    },
    // Wallet Option
    {
        name: 'wallet.payments.index',
        path:'/wallet/payments',
        component: require('./views/wallet/payments/index').default
    },
    {
        name: 'order.index',
        path:'/orders',
        component: require('./views/order/index').default
    },
    {
        name: 'order.show',
        path:'/orders/:order',
        component: require('./views/order/show').default
    },
    // Delivery
    {
        name: 'delivery.center.index',
        path:'/delivery-centers',
        component: require('./views/delivery/center/index').default
    },
    // Web Management
    // slider
    {
        name: 'web.slider.index',
        path:'/web-management/slider',
        component: require('./views/web-management/slider/index').default
    },

    {
        name: 'site-option.index',
        path:'/options',
        component: require('./views/option/index').default
    },
];

let router =  new VueRouter({
    routes,
    linkActiveClass: 'active'
});

// router.beforeEach()

export default router