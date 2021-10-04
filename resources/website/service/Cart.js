import swal from 'sweetalert'
import store from '../store'

export default class Cart {
    static addToCart(item){
        swal('Loading', {
            button: false,
            closeOnClickOutside: false
        });

        window.axios.post(`/cart/${item.id}`, item).then(({ data }) => {
            store.commit('addToCart', data);

            swal('This product is added to your cart!', {
                buttons: {
                    continue_shopping: {
                        text: "Continue Shopping",
                        value: 'shopping'
                    },
                    go_to_cart_page: {
                        text: "Go to cart page",
                        value: 'cart'
                    }
                }
            }).then((value) => {
                switch(value){
                    case 'cart':
                        location.href = '/cart'
                    break;
                }
            })
        }).catch(() => {
            swal('Error!', {
                icon: 'error'
            })
        })
    }

    static getProducts(){
        return window.axios.get('/cart', {
            params: {
                ajax: true
            }
        }).then(({ data }) => {
            store.commit('cart', data);
        })
    }

    static remove(id){
        window.axios.delete(`/cart/${id}`).then(({ data }) => {
            store.commit('removeCartItem', {
                id,
                total: data.total,
                subtotal: data.subtotal
            })
        })
    }

    static update(form){
        return window.axios.post('/cart', new FormData(form)).then(({ data }) => {
            store.commit('cart', data)
            swal('Cart items updated!', {
                icon: 'success'
            })
        })
    }

    static setDistrict(id){
        return window.axios.post(`/cart/${id}/set-district`).then(({ data }) => {
            store.commit('setCartTotal', data.total)
            store.commit('setSubtotal', data.subtotal)
        })
    }
}