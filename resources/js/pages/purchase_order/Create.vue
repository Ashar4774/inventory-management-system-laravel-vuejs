<script setup lang="ts">
import {onMounted, ref} from 'vue';
import AppLayout from "@/layouts/AppLayout.vue";
import {type BreadcrumbItem } from "@/types";
import {Head, useForm} from "@inertiajs/vue3";
import {PlusIcon, TrashIcon, PenIcon, EyeIcon} from "lucide-vue-next";
import axios from 'axios';

const props = defineProps(['categories', 'inventories','vendors']);
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Purchase Order',
        href: '/purchase-order'
    }
]

const form = useForm({
    //
});
const orderNumber = ref();
const inventoryList = ref([]);

const inventoryListRow = () => {
    inventoryList.value.push({
        product_name: '',
        category: '',
        quantity: 0,
        price: 0,
        discount: 0,
        discount_type: ''
    })
}

const generateOrderNumber = () => {
    const timestamp = new Date().getTime();
    const random = Math.floor(1000 + Math.random() * 9000 );
    orderNumber.value = `PO-${timestamp}-${random}`;
}

onMounted(()=>{
    inventoryListRow();
    generateOrderNumber();
})
const addInventoryList = () => {
    inventoryList.value.push({
        product_name: '',
        category: '',
        quantity: 0,
        price: 0,
        discount: 0,
        discount_type: '',
        total_price: '',
    })
}

const removeInventoryList = (index) => {
    inventoryList.value.splice(index, 1)
}

</script>

<template>
    <Head title="Purchase Order - Create" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 md:min-h-min">
                <form @submit.prevent="createInventoryForm">
                    <div class="flex flex-row gap-2">
                        <div class="w-1/2 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-10">
                            <div class="relative z-0 w-full mb-5 group">
                                <!--                        <input type="text" v-model="form.title" id="floating_first_name" placeholder=" " :class="[-->
                                <!--                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',-->
                                <!--                                    form.errors.title-->
                                <!--                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'-->
                                <!--                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'-->
                                <!--                                ]" />-->
                                <input type="text"  id="floating_first_name" placeholder=" " :class="[
                                        'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer'
                                    ]" v-model="orderNumber" />
                                <label for="floating_product_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Order Number</label>
                                <!--                        <p v-if="form.errors.title && form.title == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                            {{ form.errors.title }}
                                                        </p>-->
                            </div>
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                        <option selected disabled>Vendor</option>
                                        <option v-for="vendor in vendors" :key="vendor.id" :value="vendor.id">{{ vendor.name }}</option>
                                    </select>
                                    <!--                            <p v-if="form.errors.category_id && form.category_id == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                                    {{ form.errors.category_id }}
                                                                </p>-->
                                </div>

                            </div>
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="date"  id="floating_phone" :class="[
                                        'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer'
                                    ]" placeholder=" " />
                                    <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Order Date</label>
                                    <!--                            <p v-if="form.errors.purchase_price && form.purchase_price == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                                    {{ form.errors.purchase_price }}
                                                                </p>-->
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="date"  id="floating_company" :class="[
                                        'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer'
                                    ]" placeholder=" " />
                                    <label for="floating_company" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Delivery Date</label>
                                    <!--                            <p v-if="form.errors.sell_price && form.sell_price == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                                    {{ form.errors.sell_price }}
                                                                </p>-->
                                </div>
                            </div>
                            <div class="grid md:grid-cols-1 md:gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <textarea  id="floating_description" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " ></textarea>
                                    <label for="floating_description" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Note for the vendor</label>
                                    <!--                            <p v-if="form.errors.description && form.description == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                                    {{ form.errors.description }}
                                                                </p>-->
                                </div>
                            </div>
                            <!--                        <div >
                                                        <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Create</button>
                                                    </div>-->
                        </div>
                        <div class="w-1/2 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-10">
                            <div class="relative z-0 w-full mb-5 group">

                                <input type="text"  id="floating_first_name" placeholder=" " value="0" readonly :class="[
                                        'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer'
                                    ]" />
                                <label for="floating_product_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Sub Total</label>
                                <!--                        <p v-if="form.errors.title && form.title == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                            {{ form.errors.title }}
                                                        </p>-->
                            </div>
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="number"  id="floating_quantity" :class="[
                                        'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer'
                                    ]" placeholder=" " value="" />
                                    <label for="floating_quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Discount</label>
                                    <!--                            <p v-if="form.errors.qty && form.qty == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                                    {{ form.errors.qty }}
                                                                </p>-->
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >

                                        <option selected disabled>Discount type</option>
                                        <option value="amount">Amount</option>
                                        <option value="percent">Percent</option>
                                        <!--                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>-->
                                    </select>
                                    <!--                            <p v-if="form.errors.category_id && form.category_id == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                                    {{ form.errors.category_id }}
                                                                </p>-->
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-5 group">

                                <input type="text"  id="floating_first_name" placeholder=" " value="0" readonly :class="[
                                        'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer'
                                    ]" />
                                <label for="floating_product_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Total Amount</label>
                                <!--                        <p v-if="form.errors.title && form.title == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                            {{ form.errors.title }}
                                                        </p>-->
                            </div>
                        </div>
                    </div>
                    <div class="flex mt-2">
                        <div class="w-full rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-10">
                            <div class="relative z-0 w-full mb-5 group">
                                <a href="" @click.prevent="addInventoryList" class="text-blue-600 hover:text-black underline">Add new inventory</a>
                            </div>
                            <div class="inventory-items" v-if="inventoryList.length">
                                <div class="grid md:grid-cols-7 md:gap-6" id="" v-for="(inventory, index) in inventoryList"
                                     :key="index">
                                    <div class="relative z-0 w-full mb-5 group">
                                        <input type="text"  :id="'floating_product_name_' + index" list="productOptions" placeholder=" " value="" :class="[
                                        'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer text-capitalize'
                                    ]" />
                                        <label :for="'floating_product_name_' + index" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Product Name</label>
                                        <datalist id="productOptions" class="hidden border-b border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >

                                            <!--                                        <option selected disabled>Category</option>-->
                                            <option v-for="inventory in inventories" :key="inventory.id" :value="inventory.title" />
                                        </datalist>
                                        <!--                        <p v-if="form.errors.title && form.title == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                                    {{ form.errors.title }}
                                                                </p>-->
                                    </div>
                                    <div class="relative z-0 w-full mb-5 group">
                                        <select id="countries" class=" border-b border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >

                                            <option selected disabled>Category</option>
                                            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
                                        </select>
                                        <!--                            <p v-if="form.errors.category_id && form.category_id == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                                        {{ form.errors.category_id }}
                                                                    </p>-->
                                    </div>
                                    <div class="relative z-0 w-full mb-5 group">
                                        <input type="number"  id="floating_quantity" :class="[
                                        'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer'
                                    ]" placeholder=" " value="" />
                                        <label for="floating_quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Quantity</label>
                                        <!--                            <p v-if="form.errors.qty && form.qty == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                                        {{ form.errors.qty }}
                                                                    </p>-->
                                    </div>
                                    <div class="relative z-0 w-full mb-5 group">
                                        <input type="number"  id="floating_quantity" :class="[
                                        'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer'
                                    ]" placeholder=" " value="" />
                                        <label for="floating_quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Purchase Price</label>
                                        <!--                            <p v-if="form.errors.qty && form.qty == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                                        {{ form.errors.qty }}
                                                                    </p>-->
                                    </div>
                                    <div class="relative z-0 w-full mb-5 group">
                                        <input type="number"  id="floating_quantity" :class="[
                                        'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer'
                                    ]" placeholder=" " value="" />
                                        <label for="floating_quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Discount</label>
                                        <!--                            <p v-if="form.errors.qty && form.qty == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                                        {{ form.errors.qty }}
                                                                    </p>-->
                                    </div>
                                    <div class="relative z-0 w-full mb-5 group">
                                        <select id="countries" class=" border-b border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >

                                            <option selected disabled>Discount type</option>
                                            <option value="amount">Amount</option>
                                            <option value="percent">Percent</option>
                                            <!--                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>-->
                                        </select>
                                        <!--                            <p v-if="form.errors.category_id && form.category_id == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                                        {{ form.errors.category_id }}
                                                                    </p>-->
                                    </div>
                                    <div class="relative z-0 w-full mb-5 group flex gap-3">
                                        <input type="number"  id="floating_quantity" :class="[
                                        'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer'
                                    ]" placeholder=" " value="0" readonly />
                                        <label for="floating_quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Total Price</label>
                                        <!--                            <p v-if="form.errors.qty && form.qty == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                                                        {{ form.errors.qty }}
                                                                    </p>-->
                                        <button class="text-red-600" :class="[inventoryList.length == 1 ? 'hidden' : '']" @click="removeInventoryList(index)"><TrashIcon/></button>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </AppLayout>

</template>

<style scoped>

</style>
