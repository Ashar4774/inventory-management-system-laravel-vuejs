<script setup lang="ts">

import {EyeIcon, PenIcon, TrashIcon} from "lucide-vue-next";

const props = defineProps(['vendors' , 'EditVendorModel', 'DeleteVendorModel']);
</script>

<template>
    <tr v-for="vendor in props.vendors" :key="vendor.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ vendor.name }}
        </th>
        <td class="px-6 py-4">
            {{ vendor.phone_no }}
        </td>
        <td class="px-6 py-4">
            {{ vendor.address }}
        </td>
        <td class="px-6 py-4 flex gap-1">
            <button @click="DeleteVendorModel(vendor.id)" class="text-red-600"><TrashIcon/></button>
            <button @click="EditVendorModel(vendor.id)" class="text-green-600"><PenIcon /></button>
            <a href="" class="text-blue-600"><EyeIcon /></a>
        </td>
    </tr>
</template>

<style scoped>

</style>
