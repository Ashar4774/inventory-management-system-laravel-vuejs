<script setup lang="ts">

import { ref } from "vue";
import AppLayout from "@/layouts/AppLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import {EyeIcon, PenIcon, PlusIcon, TrashIcon} from "lucide-vue-next";
import {BreadcrumbItem} from "@/types";

import CreateModel from "@/pages/category/includes/CreateModel.vue";
import EditModel from "@/pages/category/includes/EditModel.vue";
import DeleteModel from "@/pages/category/includes/DeleteModel.vue";
import axios from "axios";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Category',
        href: '/category'
    }
];

const form = useForm({
    'id': '',
    'title': '',
    'description': ''
});

const props = defineProps(['categories']);

const show_create_category_modal = ref(false);
const show_edit_category_modal = ref(false);
const show_delete_category_modal = ref(false);

// Create module
const addCategoryModel = () => {
    show_create_category_modal.value = true;
}

const closeCreateCategoryModel = () => {
    show_create_category_modal.value = false;
    form.reset();
}

// Edit module
const editCategoryModel = async (id) => {
    show_edit_category_modal.value = true;
    await axios.get(`category/${id}/edit`).then( response => {
        form.id = response.data.category.id;
        form.title = response.data.category.title;
        form.description = response.data.category.description;
    }).catch( error => {
        console.error(error);
    })

}

const closeEditCategoryModel = () => {
    show_edit_category_modal.value = false;
    form.reset();
}

// Delete module
const deleteCategoryModel = async (id) => {
    show_delete_category_modal.value = true;
    await axios.get(`/category/${id}`)
        .then(response=>{
            form.id = response.data.category.id;
            form.title = response.data.category.title;
            form.description = response.data.category.description;
        }).catch(error=>{
            console.error(error);
        })
}

const closeDeleteCategoryModel = () => {
    show_delete_category_modal.value = false;
    form.reset();
}

</script>

<template>
    <Head title="Category" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div class="flex justify-between p-3">
                    <h2 class="">Category List</h2>
                    <button class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 inline-flex items-center" type="button" @click="addCategoryModel">
                        <PlusIcon />Add Category
                    </button>
                </div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Category name
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="category in categories" :key="category.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ category.title }}
                        </th>
                        <td class="px-6 py-4">
                            {{ category.description ?? '-' }}
                        </td>
                        <td class="px-6 py-4 flex gap-1">
                            <button @click="deleteCategoryModel(category.id)" class="text-red-600"><TrashIcon/></button>
                            <button @click="editCategoryModel(category.id)" class="text-green-600"><PenIcon /></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Inventory modal -->
        <CreateModel :show_create_category_modal="show_create_category_modal" :form="form" @closeCategoryModel="closeCreateCategoryModel" />

        <!-- Edit Inventory modal -->
        <EditModel :show_edit_category_modal="show_edit_category_modal" :form="form" @closeCategoryModel="closeEditCategoryModel" />

        <!-- Delete Inventory modal -->
        <DeleteModel :show_delete_category_modal="show_delete_category_modal" :form="form" @closeCategoryModel="closeDeleteCategoryModel" />
    </AppLayout>
</template>

<style scoped>

</style>
