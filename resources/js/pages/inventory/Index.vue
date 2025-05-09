<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from "@/layouts/AppLayout.vue";
import {type BreadcrumbItem } from "@/types";
import {Head, useForm} from "@inertiajs/vue3";
import {PlusIcon, TrashIcon, PenIcon, EyeIcon} from "lucide-vue-next";
import axios from 'axios';
import InventoryList from "@/pages/inventory/includes/InventoryList.vue";
import CreateModel from "@/pages/inventory/includes/CreateModel.vue";
import EditModel from "@/pages/inventory/includes/EditModel.vue";
import DeleteModel from "@/pages/inventory/includes/DeleteModel.vue";

const props = defineProps(['categories', 'inventories', 'inventory']);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Inventory',
        href: '/inventory'
    }
]

const form = useForm({
    'id': '',
    'title': '',
    'category_id': '',
    'qty': '',
    'purchase_price': '',
    'sell_price': '',
    'description': ''
});


// Add Invoice Model module
const show_create_inventory_modal = ref(false);
const addInvoiceModel = () => {
    show_create_inventory_modal.value = true
}

const closeCreateInvoiceModel = () => {
    show_create_inventory_modal.value = false;
    form.reset();
}


// Edit Invoice Model Module
const show_edit_inventory_modal = ref(false);
const editInvoiceModel = async (id) => {
    show_edit_inventory_modal.value = true;

    await axios.get(`/inventory/${id}/edit`)
        .then((data)=>{
            form.id = data.data.inventory.id;
            form.title = data.data.inventory.title;
            form.category_id = data.data.inventory.category.id;
            form.qty = data.data.inventory.qty;
            form.purchase_price = data.data.inventory.purchase_price;
            form.sell_price = data.data.inventory.sell_price;
            form.description = data.data.inventory.description;
        }).catch((error)=>{
            console.error(error);
    });
}


const closeEditInvoiceModel = () => {
    show_edit_inventory_modal.value = false;
    form.reset();
}

// Delete Invoice Model Module
const show_delete_inventory_modal = ref(false);

const deleteInvoiceModel = async (id) => {
    show_delete_inventory_modal.value = true;
    await axios.get(`/inventory/${id}`)
        .then(response=>{
            form.id = response.data.inventory.id;
            form.title = response.data.inventory.title;
        }).catch(error=>{
            console.error(error);
    })
}

const closeDeleteInvoiceModel = () => {
    show_delete_inventory_modal.value = false;
    form.reset();
}
</script>

<template>
    <Head title="Inventory" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div class="flex justify-between p-3">
                    <h2 class="">Inventory List</h2>
                    <button class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 inline-flex items-center" type="button" @click="addInvoiceModel">
                        <PlusIcon />Add Inventory
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
                        <InventoryList :inventories="props.inventories" :deleteInvoice="deleteInvoiceModel" :editInvoice="editInvoiceModel" />
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Inventory modal -->
        <CreateModel :show_create_inventory_modal="show_create_inventory_modal" :form="form" :categories="props.categories" @close="closeCreateInvoiceModel" />

        <!-- Edit Inventory modal -->
        <EditModel :show_edit_inventory_modal="show_edit_inventory_modal" :form="form" :categories="props.categories" @close="closeEditInvoiceModel" />

        <!-- Delete Inventory modal -->
        <DeleteModel :show_delete_inventory_modal="show_delete_inventory_modal" :form="form" :categories="props.categories" @close="closeDeleteInvoiceModel" />
    </AppLayout>

</template>

<style scoped>

</style>
