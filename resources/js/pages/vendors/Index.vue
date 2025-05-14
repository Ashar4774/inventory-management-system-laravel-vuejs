<script setup lang="ts">

import {ref} from "vue";
import AppLayout from "@/layouts/AppLayout.vue";
import {type BreadcrumbItem } from "@/types";
import {Head, useForm} from "@inertiajs/vue3";
import {PlusIcon, TrashIcon, PenIcon, EyeIcon} from "lucide-vue-next";
import VendorList from "@/pages/vendors/includes/VendorList.vue";
import CreateModel from "@/pages/vendors/includes/CreateModel.vue";
import EditModel from "@/pages/vendors/includes/EditModel.vue";
import axios from "axios";
import DeleteModel from "@/pages/vendors/includes/DeleteModel.vue";
import ViewModel from "@/pages/vendors/includes/ViewModel.vue";

const props = defineProps(['vendors']);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Vendor',
        href: '/vendor'
    }
]

const form = useForm({
    'id': '',
    'name': '',
    'address': '',
    'phone_no': '',
    'description': '',
})

const show_create_vendor_modal = ref(false);

const addVendorModel = () => {
    show_create_vendor_modal.value = true;
}

const closeVendorCreateModel = () => {
    show_create_vendor_modal.value = false;
    form.reset();
}


// Edit module
const show_edit_vendor_modal = ref(false);

const EditVendorModel = async (id) => {
    show_edit_vendor_modal.value = true;

    await axios.get(`/vendor/${id}/edit`).then(response=>{
        console.log(response.data);
        form.id = response.data.vendor.id;
        form.name = response.data.vendor.name;
        form.address = response.data.vendor.address;
        form.phone_no = response.data.vendor.phone_no;
        form.description = response.data.vendor.description;
    }).catch(error=>{
        console.error(error.data);
    })
}

const closeVendorEditModel = () => {
    show_edit_vendor_modal.value = false;
    form.reset();
}

// Delete module
const show_delete_vendor_modal = ref(false);

const DeleteVendorModel = (id) => {
    show_delete_vendor_modal.value = true;

    axios.get(`/vendor/${id}`).then(response=>{
        form.id = response.data.vendor.id;
        form.name = response.data.vendor.name;
    })
}
const closeDeleteVendorModel = () => {
    show_delete_vendor_modal.value = false;
    form.reset();
}

// View module
const show_view_vendor_modal = ref(false);
const ViewVendorModel = (id) => {
    show_view_vendor_modal.value = true;

    axios.get(`/vendor/${id}`).then(response=>{
        console.table(response.data.vendor)
        form.id = response.data.vendor.id;
        form.name = response.data.vendor.name;
        form.address = response.data.vendor.address;
        form.phone_no = response.data.vendor.phone_no;
        form.description = response.data.vendor.description;
    })
}

const closeViewVendorModel = () => {
    show_view_vendor_modal.value = false;
    form.reset();
}
</script>

<template>
    <Head title="Vendor" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div class="flex justify-between p-3">
                    <h2 class="">Vendor List</h2>
                    <button class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 inline-flex items-center" type="button" @click="addVendorModel">
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
                        <VendorList :vendors="vendors" :EditVendorModel="EditVendorModel" :DeleteVendorModel="DeleteVendorModel" :ViewVendorModel="ViewVendorModel" />
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Inventory modal -->
        <CreateModel :form="form" :show_create_vendor_modal="show_create_vendor_modal" @closeVendorCreateModel="closeVendorCreateModel" />

        <!-- Edit Inventory modal -->
        <EditModel :form="form" :show_edit_vendor_modal="show_edit_vendor_modal" @closeVendorEditModel="closeVendorEditModel" />

        <!-- Delete Inventory modal -->
        <DeleteModel :form="form" :show_delete_vendor_modal="show_delete_vendor_modal" @closeDeleteVendorModel="closeDeleteVendorModel" />

<!--         View Vendor model-->
        <ViewModel :form="form" :show_view_vendor_modal="show_view_vendor_modal" @closeViewVendorModel="closeViewVendorModel" />
    </AppLayout>
</template>

<style scoped>

</style>
