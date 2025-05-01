<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from "@/layouts/AppLayout.vue";
import {type BreadcrumbItem } from "@/types";
import {Head, useForm} from "@inertiajs/vue3";
import {PlusIcon} from "lucide-vue-next";

const show_create_inventory_modal = ref(false);

defineProps(['categories']);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Inventory',
        href: '/inventory'
    }
]

const addInvoiceModel = () => {
    show_create_inventory_modal.value = true
}

const form = useForm({
    'title': '',
    'category_id': '',
    'qty': '',
    'purchase_price': '',
    'sell_price': '',
    'description': ''
});

const createInventoryForm = () => {
    console.log(form);
    form.post('/inventory')
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
                            Purchase Price
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Sell Price
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Apple MacBook Pro 17"
                        </th>
                        <td class="px-6 py-4">
                            Laptop
                        </td>
                        <td class="px-6 py-4">
                            50
                        </td>
                        <td class="px-6 py-4">
                            $2500
                        </td>
                        <td class="px-6 py-4">
                            $3000
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Microsoft Surface Pro
                        </th>
                        <td class="px-6 py-4">
                            Laptop PC
                        </td>
                        <td class="px-6 py-4">
                            15
                        </td>

                        <td class="px-6 py-4">
                            $1499
                        </td>
                        <td class="px-6 py-4">
                            $1999
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
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" @click="show_create_inventory_modal = false">
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
                                <p v-if="form.errors.title" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                    {{ form.errors.title }}
                                </p>
                            </div>
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" v-model="form.category_id">

                                        <option selected>Category</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
                                    </select>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="number" v-model="form.qty" id="floating_quantity" :class="[
                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',
                                    form.errors.qty
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]" placeholder=" " value="1" />
                                    <label for="floating_quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Quantity</label>
                                    <p v-if="form.errors.qty" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                        {{ form.errors.qty }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="number" v-model="form.purchase_price" id="floating_phone" :class="[
                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',
                                    form.errors.purchase_price
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]" placeholder=" " />
                                    <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Purchase Price ($1499)</label>
                                    <p v-if="form.errors.purchase_price" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                        {{ form.errors.purchase_price }}
                                    </p>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="number" v-model="form.sell_price" id="floating_company" :class="[
                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',
                                    form.errors.sell_price
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]" placeholder=" " />
                                    <label for="floating_company" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Sell Price ($1999)</label>
                                    <p v-if="form.errors.sell_price" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                        {{ form.errors.sell_price }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid md:grid-cols-1 md:gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <textarea v-model="form.description" id="floating_description" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " ></textarea>
                                    <label for="floating_description" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Description</label>
                                    <p v-if="form.errors.description" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                        {{ form.errors.description }}
                                    </p>
                                </div>
                            </div>
                            <div >
                                <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Create</button>
                            </div>
                        </form>
                    </div>
                    <!-- Modal footer -->
<!--                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="button" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Create</button>
                    </div>-->
                </div>
            </div>
        </div>
    </AppLayout>

</template>

<style scoped>

</style>
