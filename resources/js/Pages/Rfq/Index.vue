<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    rfqs: {
        type: Array,
        default: () => [] // <-- Safety Shield! Prevents the white screen crash.
    }
});
</script>

<template>
    <Head title="RFQs" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-slate-900 leading-tight">Requests for Quotation</h2>
                <Link :href="route('rfqs.create')" class="bg-blue-600 text-white px-4 py-2 rounded-md font-bold hover:bg-slate-900 transition">
                    + Create RFQ
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b border-gray-200">
                    <div class="p-6">
                        <div v-if="!rfqs || rfqs.length === 0" class="text-center py-8 text-gray-500 font-bold">
                            No RFQs found. Click the button above to create your first one!
                        </div>
                        
                        <table v-else class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-900 text-white uppercase text-xs font-bold tracking-wider">
                                    <th class="p-4">Title</th>
                                    <th class="p-4">Deadline</th>
                                    <th class="p-4">Status</th>
                                    <th class="p-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="rfq in rfqs" :key="rfq.id" class="hover:bg-gray-50 border-b">
                                    <td class="p-4 font-semibold text-slate-900">{{ rfq.title }}</td>
                                    <td class="p-4 text-slate-600">{{ new Date(rfq.deadline).toLocaleDateString() }}</td>
                                    <td class="p-4">
                                        <span class="border border-blue-600 text-blue-600 px-3 py-1 rounded-full text-xs font-bold uppercase">
                                            {{ rfq.status }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <Link :href="route('rfqs.show', rfq.id)" class="text-blue-600 hover:text-slate-900 font-bold underline">
                                            View Details
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>