<script setup lang="ts">
const props = defineProps(['show_edit_inventory_modal', 'form', 'categories']);

const emits = defineEmits(['close']);

const editInventoryForm = (id) => {
    props.form.put(`/inventory/${id}`, {
        onSuccess: () => {
            closeEditInvoiceModel();
        }
    })
}

const closeEditInvoiceModel = () => {
    emits('close');
}
</script>

<template>
    <div v-if="show_edit_inventory_modal" id="create-inventory-modal" class="fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-500">
        <div class="relative p-4 w-full max-w-2xl max-h-full mx-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Inventory
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" @click="closeEditInvoiceModel">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only" >Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <form class="p-5" @submit.prevent="editInventoryForm(props.form.id)">


                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" v-model="props.form.title" id="floating_first_name" placeholder=" " :class="[
                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',
                                    props.form.errors.title
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]" />
                            <label for="floating_product_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Product Name</label>
                            <p v-if="props.form.errors.title && props.form.title == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                {{ props.form.errors.title }}
                            </p>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" v-model="props.form.category_id" :class="[
                                    props.form.errors.category_id && props.form.category_id == ''
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]">

                                    <option selected disabled>Category</option>
                                    <option v-for="category in props.categories" :key="category.id" :value="category.id">{{ category.title }}</option>
                                </select>
                                <p v-if="props.form.errors.category_id && props.form.category_id == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                    {{ props.form.errors.category_id }}
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <input type="number" v-model="props.form.qty" id="floating_quantity" :class="[
                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',
                                    props.form.errors.qty && props.form.qty == ''
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]" placeholder=" " value="1" />
                                <label for="floating_quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Quantity</label>
                                <p v-if="props.form.errors.qty && props.form.qty == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                    {{ props.form.errors.qty }}
                                </p>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <input type="number" v-model="props.form.purchase_price" id="floating_phone" :class="[
                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',
                                    props.form.errors.purchase_price && props.form.purchase_price == ''
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]" placeholder=" " />
                                <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Purchase Price ($1499)</label>
                                <p v-if="props.form.errors.purchase_price && props.form.purchase_price == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                    {{ props.form.errors.purchase_price }}
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <input type="number" v-model="props.form.sell_price" id="floating_company" :class="[
                                    'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer',
                                    props.form.errors.sell_price && props.form.sell_price == ''
                                        ? 'border-red-500 text-red-900 dark:border-red-400 dark:text-red-400 focus:border-red-600'
                                        : 'text-gray-900 border-gray-300 dark:text-white dark:border-gray-600 focus:border-blue-600'
                                ]" placeholder=" " />
                                <label for="floating_company" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Sell Price ($1999)</label>
                                <p v-if="props.form.errors.sell_price && props.form.sell_price == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                    {{ props.form.errors.sell_price }}
                                </p>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-1 md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <textarea v-model="props.form.description" id="floating_description" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " ></textarea>
                                <label for="floating_description" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Description</label>
                                <p v-if="props.form.errors.description && props.form.description == ''" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                    {{ props.form.errors.description }}
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
</template>

<style scoped>

</style>
