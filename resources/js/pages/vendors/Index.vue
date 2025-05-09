<script setup lang="ts">

import AppLayout from "@/layouts/AppLayout.vue";
import {type BreadcrumbItem } from "@/types";
import {Head} from "@inertiajs/vue3";
import {PlusIcon, TrashIcon, PenIcon, EyeIcon} from "lucide-vue-next";

const props = defineProps(['vendors']);
// import VendorList from "@/pages/vendors/includes/VendorList.vue";
// import CreateModel from "@/pages/vendors/includes/CreateModel.vue";
// import EditModel from "@/pages/vendors/includes/EditModel.vue";
// import DeleteModel from "@/pages/vendors/includes/DeleteModel.vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Vendor',
        href: '/vendor'
    }
]
</script>

<template>
    <Head title="Vendor" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div class="flex justify-between p-3">
                    <h2 class="">Vendor List</h2>
                    <button class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 inline-flex items-center" type="button" @click="addInvoiceModel">
                        <PlusIcon />Add Vendor
                    </button>
                </div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Vendor name
                            </th>

                            <th scope="col" class="px-6 py-3">
                                Phone No.
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Address
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
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
                                <button class="text-red-600"><TrashIcon/></button>
                                <button class="text-green-600"><PenIcon /></button>
                                <a href="" class="text-blue-600"><EyeIcon /></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Inventory modal -->


        <!-- Edit Inventory modal -->


        <!-- Delete Inventory modal -->

    </AppLayout>
</template>

<style scoped>

</style>
