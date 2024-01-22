<template>
    <div class="my-5 py-5">
        <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
            <TopTabsItem
                v-on:click="currentTab = MyTabOne"
                :active="currentTab === MyTabOne"
                :aria-current="(currentTab === MyTabOne) ? 'page' : false"
            >
                MyTabOne
            </TopTabsItem>

            <TopTabsItem
                v-on:click="currentTab = MyTabTwo"
                :active="currentTab === MyTabTwo"
                :aria-current="(currentTab === MyTabTwo) ? 'page' : false"
            >
                MyTabTwo
            </TopTabsItem>

            <TopTabsItem
                v-on:click="currentTab = MyTabThree"
                :active="currentTab === MyTabThree"
                :aria-current="(currentTab === MyTabThree) ? 'page' : false"
            >
                MyTabThree
            </TopTabsItem>

            <TopTabsItem
                v-on:click="currentTab = MyTabThree"
                :active="currentTab === MyTabThree"
                disabled="true"
                :aria-current="(currentTab === MyTabThree) ? 'page' : false"
            >
                MyTabThree
            </TopTabsItem>
        </ul>

        <KeepAlive>
            <component :is="currentTab"></component>
        </KeepAlive>
    </div>
</template>

<script setup>
import { onMounted, computed, shallowRef, defineProps } from 'vue'
import MyTabOne from '@/components/parts/dashboard/MyTabOne.vue'
import MyTabTwo from '@/components/parts/dashboard/MyTabTwo.vue'
import MyTabThree from '@/components/parts/dashboard/MyTabThree.vue'
import TopTabsItem from '@/components/parts/dashboard/TopTabsItem.vue'
const props = defineProps([
    'activeTab',
])

let tabs = {
    MyTabOne: MyTabOne,
    MyTabTwo: MyTabTwo,
    MyTabThree: MyTabThree,
}

const getTabByActive = (active) => {
    return (active in tabs) ? tabs[active] : MyTabThree;
}

console.log('activeTab', props.activeTab);
const currentTab = shallowRef(getTabByActive(props.activeTab))

console.log('currentTab', currentTab);
</script>
