<script setup lang="ts">

import {EyeIcon, PenIcon, TrashIcon} from "lucide-vue-next";

const listProp = defineProps(['inventories', 'editInvoice', 'deleteInvoice'])
</script>

<template>
    <tr v-for="inventory in inventories" :key="inventory.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ inventory.title }}
        </th>
        <td class="px-6 py-4">
            {{ inventory.category.title }}
        </td>
        <td class="px-6 py-4">
            {{ inventory.qty }}
        </td>
        <td class="px-6 py-4">
            {{ inventory.purchase_price }}
        </td>
        <td class="px-6 py-4">
            {{ inventory.sell_price }}
        </td>
        <td class="px-6 py-4 flex gap-1">
            <button @click.prevent="deleteInvoice(inventory.id)" class="text-red-600"><TrashIcon/></button>
            <button @click.prevent="editInvoice(inventory.id)" class="text-green-600"><PenIcon /></button>
            <a href="" @click="viewInvoiceModel" class="text-blue-600"><EyeIcon /></a>
        </td>
    </tr>
</template>

<style scoped>

</style>
