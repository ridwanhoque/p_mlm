import swal from 'sweetalert'

class Wishlist {
    static store(itemId, itemClass){
        return window.axios.post(`/wishlist/${itemId}/${itemClass}`).then(({ data }) => {
            swal(data.message, {
                icon: 'success',
                timer: 2000
            });
        })
    }
}

export default Wishlist