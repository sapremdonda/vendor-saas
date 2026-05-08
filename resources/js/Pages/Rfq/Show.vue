<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({
    rfq: Object,
    availableVendors: {
        type: Array,
        default: () => [] // Safety fallback!
    },
});

const inviteForm = useForm({
    vendor_id: '',
});

// Vue Magic with Safety Shields!
const uninvitedVendors = computed(() => {
    const allVendors = props.availableVendors || [];
    const invitedVendors = props.rfq?.vendors || [];

    return allVendors.filter(vendor => {
        return !invitedVendors.some(invited => invited.id === vendor.id);
    });
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
                title: 'Vendor Invited!',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
};

const deleteRfq = () => {
    Swal.fire({
        title: 'Confirm Deletion',
        text: "Are you sure you want to delete this Request for Quotation? This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Delete RFQ'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('rfqs.destroy', props.rfq.id), {
                onSuccess: () => Swal.fire('Deleted', 'The RFQ has been successfully removed.', 'success')
            });
        }
    });
};
</script>

<template>
    <Head :title="rfq?.title || 'RFQ Details'" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">RFQ Details: {{ rfq?.title }}</h2>
                
                <div class="flex space-x-3">
                    <Link v-if="rfq?.id" :href="route('rfqs.edit', rfq.id)" class="bg-yellow-500 text-white px-4 py-2 rounded-md font-bold hover:bg-yellow-600 transition">
                        Edit
                    </Link>
                    <button @click="deleteRfq" class="bg-red-600 text-white px-4 py-2 rounded-md font-bold hover:bg-red-700 transition">
                        Delete
                    </button>
                    <Link :href="route('rfqs.index')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md font-bold hover:bg-gray-300 transition">
                        &larr; Back
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-blue-600">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4">Project Description</h3>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ rfq?.description }}</p>
                        
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-2 mt-6 mb-4">Items / Services Required</h3>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ rfq?.items_required || 'No specific items listed.' }}</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4">Summary</h3>
                        
                        <div class="mb-4">
                            <span class="block text-sm text-gray-500 font-bold uppercase tracking-wider">Status</span>
                            <span class="inline-block mt-1 px-3 py-1 rounded-full text-sm font-bold uppercase"
                                  :class="{
                                      'bg-green-100 text-green-800': rfq?.status === 'Active',
                                      'bg-yellow-100 text-yellow-800': rfq?.status === 'Reviewing',
                                      'bg-blue-100 text-blue-800': rfq?.status === 'Awarded',
                                      'bg-gray-100 text-gray-800': rfq?.status === 'Archived'
                                  }">
                                {{ rfq?.status || 'Unknown' }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <span class="block text-sm text-gray-500 font-bold uppercase tracking-wider">Deadline</span>
                            <span class="block mt-1 text-gray-800 font-semibold" v-if="rfq?.deadline">{{ new Date(rfq.deadline).toLocaleDateString() }}</span>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-indigo-500">
                        <h3 class="text-md font-bold text-gray-900 mb-4 border-b pb-2">Invited Vendors</h3>
                        
                        <ul v-if="rfq?.vendors && rfq.vendors.length > 0" class="space-y-2 mb-6">
                            <li v-for="vendor in rfq.vendors" :key="vendor.id" class="bg-gray-50 p-2 rounded border text-sm flex justify-between items-center">
                                <div>
                                    <span class="font-bold block text-gray-800">{{ vendor.company }}</span>
                                    <span class="text-xs text-gray-500">{{ vendor.email }}</span>
                                </div>
                                <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full font-semibold">Invited</span>
                            </li>
                        </ul>
                        <p v-else class="text-sm text-gray-500 italic mb-4">No vendors invited yet.</p>

                        <form @submit.prevent="sendInvite" class="space-y-3">
                            <select v-model="inviteForm.vendor_id" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" required>
                                <option value="" disabled>Select a vendor to invite...</option>
                                <option v-for="vendor in uninvitedVendors" :key="vendor.id" :value="vendor.id">
                                    {{ vendor.company }} ({{ vendor.name }})
                                </option>
                            </select>
                            
                            <button type="submit" :disabled="inviteForm.processing || uninvitedVendors.length === 0" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md font-bold hover:bg-indigo-700 transition disabled:opacity-50">
                                Send Invitation
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>