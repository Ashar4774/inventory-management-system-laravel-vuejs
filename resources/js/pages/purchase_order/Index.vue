<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from "@/layouts/AppLayout.vue";
import {type BreadcrumbItem } from "@/types";
import {Head, useForm} from "@inertiajs/vue3";
import {PlusIcon, TrashIcon, PenIcon, EyeIcon} from "lucide-vue-next";
import axios from 'axios';




const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Purchase Order',
        href: '/purchase-order'
    }
]

const form = useForm({
    //
});


// Add Invoice Model module


// Edit Invoice Model Module


// Delete Invoice Model Module

</script>

<template>
    <Head title="Inventory" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div class="flex justify-between p-3">
                    <h2 class="">Order List</h2>
                    <button class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 inline-flex items-center" type="button" @click="addInvoiceModel">
                        <PlusIcon />Create Order
                    </button>
                </div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Product name
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Vendor
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Quantity
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Purchase Price(PKR)
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Sell Price(PKR)
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>

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
