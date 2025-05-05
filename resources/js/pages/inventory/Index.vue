<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from "@/layouts/AppLayout.vue";
import {type BreadcrumbItem } from "@/types";
import {Head, useForm} from "@inertiajs/vue3";
import {PlusIcon, TrashIcon, PenIcon, EyeIcon} from "lucide-vue-next";
import axios from 'axios';

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

const closeInvoiceModel = () => {
    show_create_inventory_modal.value = false;
    form.reset();
}

const createInventoryForm = () => {
    form.post('/inventory',{
        onSuccess: () => {
            form.reset();
            closeInvoiceModel();
        }
    })
}

// Edit Invoice Model Module
const edit_create_inventory_modal = ref(false);
const editInvoiceModel = async (id) => {
    edit_create_inventory_modal.value = true;

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

const editInventoryForm = (id) => {
    form.put(`/inventory/${id}`, {
        onSuccess: () => {
            edit_create_inventory_modal.value = false;
            form.reset();
        }
    })
}

const closeEditInvoiceModel = () => {
    edit_create_inventory_modal.value = false;
    form.reset();
}

// Delete Invoice Model Module
const delete_create_inventory_modal = ref(false);

const deleteInvoiceModel = async (id) => {
    delete_create_inventory_modal.value = true;
    await axios.get(`/inventory/${id}`)
        .then(response=>{
            form.id = response.data.inventory.id;
            form.title = response.data.inventory.title;
        }).catch(error=>{
            console.error(error);
    })
}

const deleteInventoryForm = (id) => {
    form.delete(`/inventory/${id}`, {
        onSuccess: () => {
            closeDeleteInvoiceModel();
        }
    })
}
const closeDeleteInvoiceModel = () => {
    delete_create_inventory_modal.value = false;
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
                        <tr v-for="inventory in props.inventories" :key="inventory.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
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
                                <button @click.prevent="deleteInvoiceModel(inventory.id)" class="text-red-600"><TrashIcon/></button>
                                <button @click.prevent="editInvoiceModel(inventory.id)" class="text-green-600"><PenIcon /></button>
                                <a href="" @click="viewInvoiceModel" class="text-blue-600"><EyeIcon /></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Inventory modal -->
        <div v-if="show_create_inventory_modal" id="create-inventory-modal" class="fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-500">
            <div class="relative p-4 w-full max-w-2xl max-h-full mx-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Create Inventory
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" @click="closeInvoiceModel()">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only" >Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <form class="p-5" @submit.prevent="createInventoryForm">


                            <div class="relative z-0 w-full mb-5 group">
                                <input type="text" v-model="form.title" id="floating_first_name" placeholder=" " :class="[
                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',
                                    form.errors.title
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]" />
                                <label for="floating_product_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Product Name</label>
                                <p v-if="form.errors.title && form.title == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                    {{ form.errors.title }}
                                </p>
                            </div>
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" v-model="form.category_id" :class="[
                                    form.errors.category_id && form.category_id == ''
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]">

                                        <option selected disabled>Category</option>
                                        <option v-for="category in props.categories" :key="category.id" :value="category.id">{{ category.title }}</option>
                                    </select>
                                    <p v-if="form.errors.category_id && form.category_id == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                        {{ form.errors.category_id }}
                                    </p>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="number" v-model="form.qty" id="floating_quantity" :class="[
                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',
                                    form.errors.qty && form.qty == ''
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]" placeholder=" " value="1" />
                                    <label for="floating_quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Quantity</label>
                                    <p v-if="form.errors.qty && form.qty == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                        {{ form.errors.qty }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="number" v-model="form.purchase_price" id="floating_phone" :class="[
                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',
                                    form.errors.purchase_price && form.purchase_price == ''
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]" placeholder=" " />
                                    <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Purchase Price ($1499)</label>
                                    <p v-if="form.errors.purchase_price && form.purchase_price == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                        {{ form.errors.purchase_price }}
                                    </p>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="number" v-model="form.sell_price" id="floating_company" :class="[
                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',
                                    form.errors.sell_price && form.sell_price == ''
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]" placeholder=" " />
                                    <label for="floating_company" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Sell Price ($1999)</label>
                                    <p v-if="form.errors.sell_price && form.sell_price == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                        {{ form.errors.sell_price }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid md:grid-cols-1 md:gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <textarea v-model="form.description" id="floating_description" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " ></textarea>
                                    <label for="floating_description" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Description</label>
                                    <p v-if="form.errors.description && form.description == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                        {{ form.errors.description }}
                                    </p>
                                </div>
                            </div>
                            <div >
                                <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Inventory modal -->
        <div v-if="edit_create_inventory_modal" id="create-inventory-modal" class="fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-500">
            <div class="relative p-4 w-full max-w-2xl max-h-full mx-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Edit Inventory
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" @click="closeEditInvoiceModel()">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only" >Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <form class="p-5" @submit.prevent="editInventoryForm(form.id)">


                            <div class="relative z-0 w-full mb-5 group">
                                <input type="text" v-model="form.title" id="floating_first_name" placeholder=" " :class="[
                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',
                                    form.errors.title
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]" />
                                <label for="floating_product_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Product Name</label>
                                <p v-if="form.errors.title && form.title == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                    {{ form.errors.title }}
                                </p>
                            </div>
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" v-model="form.category_id" :class="[
                                    form.errors.category_id && form.category_id == ''
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]">

                                        <option selected disabled>Category</option>
                                        <option v-for="category in props.categories" :key="category.id" :value="category.id">{{ category.title }}</option>
                                    </select>
                                    <p v-if="form.errors.category_id && form.category_id == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                        {{ form.errors.category_id }}
                                    </p>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="number" v-model="form.qty" id="floating_quantity" :class="[
                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',
                                    form.errors.qty && form.qty == ''
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]" placeholder=" " value="1" />
                                    <label for="floating_quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Quantity</label>
                                    <p v-if="form.errors.qty && form.qty == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                        {{ form.errors.qty }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="number" v-model="form.purchase_price" id="floating_phone" :class="[
                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',
                                    form.errors.purchase_price && form.purchase_price == ''
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]" placeholder=" " />
                                    <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Purchase Price ($1499)</label>
                                    <p v-if="form.errors.purchase_price && form.purchase_price == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                        {{ form.errors.purchase_price }}
                                    </p>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="number" v-model="form.sell_price" id="floating_company" :class="[
                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',
                                    form.errors.sell_price && form.sell_price == ''
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]" placeholder=" " />
                                    <label for="floating_company" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Sell Price ($1999)</label>
                                    <p v-if="form.errors.sell_price && form.sell_price == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                        {{ form.errors.sell_price }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid md:grid-cols-1 md:gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <textarea v-model="form.description" id="floating_description" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " ></textarea>
                                    <label for="floating_description" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Description</label>
                                    <p v-if="form.errors.description && form.description == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                        {{ form.errors.description }}
                                    </p>
                                </div>
                            </div>
                            <div >
                                <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Inventory modal -->
        <div v-if="delete_create_inventory_modal" id="create-inventory-modal" class="fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-500">
            <div class="relative p-4 w-full max-w-2xl max-h-full mx-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Edit Inventory
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" @click="closeDeleteInvoiceModel()">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only" >Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                            Do you want to delete the inventory {{ form.title }}
                        </p>
                        <form class="p-5" @submit.prevent="deleteInventoryForm(form.id)">

                            <div class="flex gap-1">
                                <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Yes</button>
                                <button type="submit" @click.prevent="closeDeleteInvoiceModel()" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">No</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

</template>

<style scoped>

</style>
