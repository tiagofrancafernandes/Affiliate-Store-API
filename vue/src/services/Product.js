import router from '@/router'
import API from '@/services/API'
import store from '@/store'
import emailVerification from '@/services/emailVerification.js'

const Product = {
    async index(params = {}) {
        const res = await API.get('/store/products', params);
        if (res?.status >= 200 && res?.status < 300) {
            return res.data
        }

        return [];
    }
}

export default Product
