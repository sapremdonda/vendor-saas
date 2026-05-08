<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({
    rfq: Object,
    availableVendors: Array,
});

const inviteForm = useForm({
    vendor_id: '',
});

const uninvitedVendors = computed(() => {
    const all = props.availableVendors || [];
    const invited = props.rfq?.vendors || [];
    return all.filter(v => !invited.some(i => i.id === v.id));
});

const sendInvite = () => {
    inviteForm.post(route('rfqs.invite', props.rfq.id), {
        preserveScroll: true,
        onSuccess: () => {
            inviteForm.reset();
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Invitation Sent',
                showConfirmButton: false,
                timer: 2000,
                background: '#0f172a',
                color: '#ffffff'
            });
        }
    });
};

const deleteRfq = () => {
    Swal.fire({
        title: 'Confirm Deletion',
        text: "This RFQ will be permanently removed from the system.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#0f172a',
        confirmButtonText: 'Confirm Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('rfqs.destroy', props.rfq.id));
        }
    });
};
</script>

<template>
    <Head :title="rfq.title" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-slate-900 leading-tight">{{ rfq.title }}</h2>
                <div class="flex space-x-3">
                    <Link :href="route('rfqs.edit', rfq.id)" class="bg-slate-900 text-white px-4 py-2 rounded-md font-bold hover:bg-blue-600 transition">
                        Edit
                    </Link>
                    <button @click="deleteRfq" class="border-2 border-slate-900 text-slate-900 px-4 py-2 rounded-md font-bold hover:bg-slate-900 hover:text-white transition">
                        Delete
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 border-t-4 border-slate-900">
                        <h3 class="text-lg font-bold text-slate-900 border-b pb-2 mb-4">Description</h3>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ rfq.description }}</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 border-t-4 border-blue-600">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Status & Deadline</h3>
                        <div class="mb-4">
                            <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold uppercase">{{ rfq.status }}</span>
                        </div>
                        <p class="text-sm font-bold text-slate-900 uppercase">Deadline: {{ new Date(rfq.deadline).toLocaleDateString() }}</p>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg p-6 border-t-4 border-slate-900">
                        <h3 class="text-md font-bold text-slate-900 mb-4 border-b pb-2">Bidding Center</h3>
                        <ul class="mb-4 space-y-2">
                            <li v-for="v in rfq.vendors" :key="v.id" class="text-sm p-2 bg-gray-50 border rounded flex justify-between">
                                <span>{{ v.company }}</span>
                                <span class="text-blue-600 font-bold text-xs uppercase">Invited</span>
                            </li>
                        </ul>
                        <form @submit.prevent="sendInvite" class="space-y-3">
                            <select v-model="inviteForm.vendor_id" class="w-full border-gray-300 rounded-md text-sm focus:ring-blue-600 focus:border-blue-600">
                                <option value="" disabled>Select Vendor</option>
                                <option v-for="v in uninvitedVendors" :key="v.id" :value="v.id">{{ v.company }}</option>
                            </select>
                            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md font-bold hover:bg-slate-900 transition">
                                Invite Vendor
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>