<template>
<h1 class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
    Home
    <span>{{ currentCategory }}</span>
</h1>
<div class="flex items-center justify-center py-4 md:py-8 flex-wrap">
    <TwButton
        v-on:click="changeCategory('all')"
        :active="currentCategory === 'all'"
    >All categories</TwButton>

    <TwButton
        v-on:click="changeCategory('shoes')"
        :active="currentCategory === 'shoes'"
    >Shoes</TwButton>

    <TwButton
        v-on:click="changeCategory('bags')"
        :active="currentCategory === 'bags'"
    >Bags</TwButton>

    <TwButton
        v-on:click="changeCategory('electronics')"
        :active="currentCategory === 'electronics'"
    >Electronics</TwButton>

    <TwButton
        v-on:click="changeCategory('gaming')"
        :active="currentCategory === 'gaming'"
    >Gaming</TwButton>

</div>
<div class="grid grid-cols-2 md:grid-cols-3 gap-4">
    <ProductCard
        v-for="(product, productIndex) in products"
        v-key="productIndex"
        :product="product"
        :debug="debugIsOn"
    />
</div>

<div class="relative rounded-xl overflow-auto p-8">
    <div class="flex items-center justify-center">
        <CustomButton
            v-on:click="loadMore()"
            class="cursor-pointer"
            v-if="!isLoading && nextLink"
        >
            Load more...
        </CustomButton>
    </div>
</div>
</template>

<script setup>
import { onMounted, watch, ref, } from "vue";
import ProductCard from '@/components/parts/shop/product/ProductCard.vue'
import CustomButton from "@/components/parts/Button.vue";
import { useRoute, useRouter } from "vue-router";
import { computed } from "@vue/reactivity";
import TwButton from '@/components/parts/forms/TwButton.vue'
import { randomNumber } from '@/helpers/numbers';
import Product from '@/services/Product'
import { settings, isProduction } from '@/services/Site'

const route = useRoute();
const router = useRouter();
let products = ref([]);
let nextLink = ref(null);
const isLoading = ref(false);
const currentCategory = computed(() => route.query.category || 'all');

const SiteSettings = computed(() => {
    console.log('settings', settings());
    return {
        ...settings(),
    }
})

const debugIsOn = computed(() => SiteSettings.app?.debugOn || !(SiteSettings.app?.isProduction) || !isProduction);

const loadData = async () => {
    // https://fakestoreapi.com/
    let fakeResponse = {"data":[{"id":1,"name":"Product maxime similique","small_description":"molestias id possimus suscipit a aliquid est non in quae","long_description":"&lt;p&gt;Qui sint eius omnis quia sed. Numquam ad doloremque error quia sit. Labore iusto est ipsum aut quidem nihil.&lt;\/p&gt;\n&lt;p&gt;Aliquid ea atque dolor voluptatibus quam. Culpa similique qui in perferendis ex autem. Et similique fuga quod vitae dicta eos reiciendis. Veritatis molestiae dolorem illum ipsa.&lt;\/p&gt;\n&lt;p&gt;At ut quaerat adipisci sit fugit eveniet. Ut aut a est velit dolor est omnis corrupti. Facilis quas eos commodi est nam enim debitis. Nisi delectus alias et animi illum.&lt;\/p&gt;","images":[{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%231%0A%0A%0A1000x1200","alt":"Picture #1   1000x1200"},{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%232%0A%0A%0A1000x1200","alt":"Picture #2   1000x1200"},{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%233%0A%0A%0A1000x1200","alt":"Picture #3   1000x1200"},{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%234%0A%0A%0A1000x1200","alt":"Picture #4   1000x1200"}],"featured":false,"show_in_store":true,"created_at":"2024-01-22T12:48:13.000000Z","updated_at":"2024-01-22T12:48:13.000000Z","deleted_at":null,"prices":[{"id":1,"product_id":1,"product_seller_id":3,"show_in_store":true,"main_price":false,"original_price":"2124.00","current_price":"1847.88","promo_price":null,"promo_price_enabled":false,"promo_price_condition_type":null,"promo_price_message":null,"created_at":"2024-01-22T12:48:13.000000Z","updated_at":"2024-01-22T12:48:13.000000Z","deleted_at":null}]},{"id":2,"name":"Product id fuga","small_description":"velit libero quis ratione pariatur sint vel repellendus odit eos","long_description":"&lt;p&gt;Molestiae et nobis repellendus dolores quis sunt delectus. Sit consequatur debitis expedita iste. Repellat et et maiores officiis. Non ut qui qui corporis ad quis sunt. Vel omnis excepturi dolorem aut dolores et.&lt;\/p&gt;\n&lt;p&gt;Ipsum laborum illo fugit minima nesciunt non. Aut modi et enim qui atque.&lt;\/p&gt;\n&lt;p&gt;Vitae hic sed voluptate aut nesciunt. Repellendus numquam animi aut reprehenderit eum. Enim voluptatum et eum eum quod et. Omnis et deleniti quidem. Ex qui vel odio veritatis nostrum.&lt;\/p&gt;","images":[{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%231%0A%0A%0A1000x1200","alt":"Picture #1   1000x1200"},{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%232%0A%0A%0A1000x1200","alt":"Picture #2   1000x1200"},{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%233%0A%0A%0A1000x1200","alt":"Picture #3   1000x1200"},{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%234%0A%0A%0A1000x1200","alt":"Picture #4   1000x1200"}],"featured":false,"show_in_store":true,"created_at":"2024-01-22T12:48:13.000000Z","updated_at":"2024-01-22T12:48:13.000000Z","deleted_at":null,"prices":[{"id":3,"product_id":2,"product_seller_id":1,"show_in_store":true,"main_price":false,"original_price":"631.00","current_price":"567.9","promo_price":null,"promo_price_enabled":false,"promo_price_condition_type":null,"promo_price_message":null,"created_at":"2024-01-22T12:48:13.000000Z","updated_at":"2024-01-22T12:48:13.000000Z","deleted_at":null},{"id":2,"product_id":2,"product_seller_id":3,"show_in_store":true,"main_price":false,"original_price":"750.00","current_price":"667.5","promo_price":null,"promo_price_enabled":false,"promo_price_condition_type":null,"promo_price_message":null,"created_at":"2024-01-22T12:48:13.000000Z","updated_at":"2024-01-22T12:48:13.000000Z","deleted_at":null}]},{"id":3,"name":"Product quo debitis","small_description":"qui vitae omnis dolores sit molestiae dolores suscipit quaerat reiciendis","long_description":"&lt;p&gt;Alias deserunt aut magnam. Deleniti quis numquam rerum aut modi quo quisquam animi. Mollitia excepturi est odit repellendus id. Aut debitis iusto eos a perferendis quisquam.&lt;\/p&gt;\n&lt;p&gt;Tempore numquam magnam reiciendis aliquid illo cupiditate cum. Iure saepe quia rerum et. Magni quis ipsa neque animi quas voluptatibus ut. Ut vel numquam voluptatem provident minus minus harum sed.&lt;\/p&gt;\n&lt;p&gt;Numquam dolores aperiam qui minus repellendus quod est minus. Nihil officiis fugiat voluptatibus dolores expedita sit dolores voluptatum. Quisquam ut reprehenderit magni repellat aut consequuntur sit. Quidem ullam quia sed perferendis ut.&lt;\/p&gt;","images":[{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%231%0A%0A%0A1000x1200","alt":"Picture #1   1000x1200"},{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%232%0A%0A%0A1000x1200","alt":"Picture #2   1000x1200"},{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%233%0A%0A%0A1000x1200","alt":"Picture #3   1000x1200"},{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%234%0A%0A%0A1000x1200","alt":"Picture #4   1000x1200"}],"featured":false,"show_in_store":true,"created_at":"2024-01-22T12:48:13.000000Z","updated_at":"2024-01-22T12:48:13.000000Z","deleted_at":null,"prices":[{"id":5,"product_id":3,"product_seller_id":3,"show_in_store":true,"main_price":false,"original_price":"1534.00","current_price":"1257.88","promo_price":null,"promo_price_enabled":false,"promo_price_condition_type":null,"promo_price_message":null,"created_at":"2024-01-22T12:48:13.000000Z","updated_at":"2024-01-22T12:48:13.000000Z","deleted_at":null},{"id":6,"product_id":3,"product_seller_id":3,"show_in_store":true,"main_price":false,"original_price":"1919.00","current_price":"1707.91","promo_price":null,"promo_price_enabled":false,"promo_price_condition_type":null,"promo_price_message":null,"created_at":"2024-01-22T12:48:13.000000Z","updated_at":"2024-01-22T12:48:13.000000Z","deleted_at":null},{"id":4,"product_id":3,"product_seller_id":4,"show_in_store":true,"main_price":false,"original_price":"2151.00","current_price":"1806.84","promo_price":null,"promo_price_enabled":false,"promo_price_condition_type":null,"promo_price_message":null,"created_at":"2024-01-22T12:48:13.000000Z","updated_at":"2024-01-22T12:48:13.000000Z","deleted_at":null}]},{"id":4,"name":"Product accusantium dolorem","small_description":"quo corporis veritatis culpa non quos consequatur ducimus in nemo","long_description":"&lt;p&gt;Quia officia corrupti voluptas quae voluptatem. Enim animi accusantium est. Dolorum dolorem perferendis fuga distinctio id.&lt;\/p&gt;\n&lt;p&gt;Officia occaecati ut repudiandae voluptates iusto. Ducimus ex officia vitae veniam quae.&lt;\/p&gt;\n&lt;p&gt;Ipsam doloribus beatae et sint velit molestiae voluptatem. Quisquam necessitatibus reprehenderit voluptates minus tempore. Ut optio quis maiores non. Deleniti excepturi est rerum inventore reprehenderit et labore in.&lt;\/p&gt;","images":[{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%231%0A%0A%0A1000x1200","alt":"Picture #1   1000x1200"},{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%232%0A%0A%0A1000x1200","alt":"Picture #2   1000x1200"},{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%233%0A%0A%0A1000x1200","alt":"Picture #3   1000x1200"},{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%234%0A%0A%0A1000x1200","alt":"Picture #4   1000x1200"}],"featured":false,"show_in_store":true,"created_at":"2024-01-22T12:48:13.000000Z","updated_at":"2024-01-22T12:48:13.000000Z","deleted_at":null,"prices":[{"id":7,"product_id":4,"product_seller_id":4,"show_in_store":true,"main_price":false,"original_price":"1560.00","current_price":"1263.6","promo_price":null,"promo_price_enabled":false,"promo_price_condition_type":null,"promo_price_message":null,"created_at":"2024-01-22T12:48:13.000000Z","updated_at":"2024-01-22T12:48:13.000000Z","deleted_at":null},{"id":8,"product_id":4,"product_seller_id":2,"show_in_store":true,"main_price":false,"original_price":"2669.00","current_price":"2375.41","promo_price":null,"promo_price_enabled":false,"promo_price_condition_type":null,"promo_price_message":null,"created_at":"2024-01-22T12:48:13.000000Z","updated_at":"2024-01-22T12:48:13.000000Z","deleted_at":null}]},{"id":5,"name":"Product reprehenderit esse","small_description":"expedita laboriosam vero voluptatibus eum officia distinctio qui occaecati cum","long_description":"&lt;p&gt;Harum occaecati sunt ut vitae itaque numquam qui quia. Nobis quia ut alias. Minus consequatur mollitia quos est voluptate rerum quo illum. Dolorem blanditiis amet fugiat voluptatem commodi dolores.&lt;\/p&gt;\n&lt;p&gt;Corrupti eius quia perferendis porro exercitationem saepe et. Recusandae consequatur et ipsa et. Cupiditate quis qui et consequatur aut vel atque.&lt;\/p&gt;\n&lt;p&gt;Esse nisi qui delectus ipsa et nesciunt sint. Ut est autem quia ea. Porro quia non deleniti. Adipisci ipsam porro ullam omnis rerum doloremque.&lt;\/p&gt;","images":[{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%231%0A%0A%0A1000x1200","alt":"Picture #1   1000x1200"},{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%232%0A%0A%0A1000x1200","alt":"Picture #2   1000x1200"},{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%233%0A%0A%0A1000x1200","alt":"Picture #3   1000x1200"},{"url":"https:\/\/via.placeholder.com\/1000x1200.png?text=Picture+%234%0A%0A%0A1000x1200","alt":"Picture #4   1000x1200"}],"featured":false,"show_in_store":true,"created_at":"2024-01-22T12:48:13.000000Z","updated_at":"2024-01-22T12:48:13.000000Z","deleted_at":null,"prices":[{"id":9,"product_id":5,"product_seller_id":4,"show_in_store":true,"main_price":false,"original_price":"1572.00","current_price":"1273.32","promo_price":null,"promo_price_enabled":false,"promo_price_condition_type":null,"promo_price_message":null,"created_at":"2024-01-22T12:48:13.000000Z","updated_at":"2024-01-22T12:48:13.000000Z","deleted_at":null},{"id":10,"product_id":5,"product_seller_id":3,"show_in_store":true,"main_price":false,"original_price":"1075.00","current_price":"967.5","promo_price":null,"promo_price_enabled":false,"promo_price_condition_type":null,"promo_price_message":null,"created_at":"2024-01-22T12:48:13.000000Z","updated_at":"2024-01-22T12:48:13.000000Z","deleted_at":null}]}],"path":"http:\/\/127.0.0.1:8000\/api\/store\/products","per_page":5,"next_cursor":"eyJwcm9kdWN0cy5pZCI6NSwiX3BvaW50c1RvTmV4dEl0ZW1zIjp0cnVlfQ","next_page_url":"http:\/\/127.0.0.1:8000\/api\/store\/products?per_page=5&perPage=2&sort_order=desc&_fields%5Bproducts%5D=id%2Cname&_filter%5Bhas_prices%5D=true&_filter%5BonlyWhereHas%5D=prices%2CpublicPriceList&_filter%5Bname%5D=fugit&_filter%5Bsmall_description%5D=verita&_filter%5BcustomSearch%5D=p%25rro&include=prices&page%5Bcursor%5D=eyJwcm9kdWN0cy5pZCI6NSwiX3BvaW50c1RvTmV4dEl0ZW1zIjp0cnVlfQ","prev_cursor":null,"prev_page_url":null};
    // fakeResponse = JSON.parse(fakeResponse);
    fakeResponse = JSON.parse(JSON.stringify(fakeResponse));

    // console.log(fakeResponse);
    console.log('before Product.index');
    let options = {};
    let searchParams = {};

    if (nextLink.value) {
        console.log(nextLink.value);
        try {
            searchParams = (new URL(nextLink.value)).searchParams;
        } catch (error) {
            searchParams = {};
        }
    }

    searchParams['sort'] = '-id';

    let responseData = await Product.index({
        params: searchParams,
    });

    console.log('Product.index', responseData);
    console.log('after Product.index');

    nextLink.value = responseData?.next_page_url

    let productList = responseData // fakeResponse;

    // [...Array(10).keys()].forEach(item => {
    //     products.value.push(item)
    // })

    productList.data?.forEach(product => {
        // product['review_rating'] = randomNumber(1, 5);
        // product['show_review_rating'] = !!(randomNumber(1, 50) % 3);
        products.value.push(product);
    })
}

const loadMore = () => {
    if (!nextLink.value) {
        return;
    }

    loadData();
}

const changeCategory = (category) => {
    console.log('changeCategory', category);

    router.push({
        // name: 'user',
        // params: { category: category },
        query: { category: category },
    })
}

watch(route, () => {
    console.log('route updated');
//   store.dispatch("searchMealsByLetter", {
//     letter: route.params.letter,
//     pageNumber: 1,
//     toAppend: false,
//   });
});

onMounted(() => {
    loadData();
//   store.dispatch("searchMealsByLetter", {
//     letter: route.params.letter,
//     pageNumber: 1,
//     toAppend: false,
//   });
});
</script>
