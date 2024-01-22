<template>
  <h1 class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">Dashboard</h1>
    <TopTabs
        :activeTab="activeTab"
    />
</template>

<script setup>
    import { onMounted, computed, shallowRef, ref, watch } from 'vue'
    import { useRoute, useRouter } from 'vue-router'
    import store from '@/store'
    import Auth from '@/services/Auth'
    import Product from '@/services/Product'
    import TopTabs from '@/components/parts/dashboard/TopTabs.vue'

    const router = useRouter()
    const route = useRoute()
    let activeTab = ref(route.query.activeTab)

    const userVerified = computed( () => store.getters['user/getEmailVerifiedAt'] )

    const verification = () => {
        return;
        if(
            typeof route.query.id === 'undefined' ||
            typeof route.query.hash === 'undefined'
        ) {
            router.push( { name: 'notFound' } )

            return
        }

        if( userVerified.value ) {
            router.push( { name: 'Dashboard' } )

            return
        }

        if( ! userVerified.value ) {
            Auth.emailVerificationCheck( {
                id: route.query.id,
                hash: route.query.hash
            } )
        }
    }

    onMounted( () => {
        verification();
        console.log('onMounted: Dashboard.vue', (new Date()));
    } )

    watch(route, () => {
        activeTab.value = route.query.activeTab;
    })
</script>
