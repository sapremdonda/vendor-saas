<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    rfqs: Array,
});
</script>

<template>
    <Head title="RFQs" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Requests for Quotation (RFQs)</h2>
                <Link :href="route('rfqs.create')" class="bg-blue-600 text-white px-4 py-2 rounded-md font-bold hover:bg-blue-700 transition">
                    + Create RFQ
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-if="rfqs.length === 0" class="text-center py-8 text-gray-500">
                            No RFQs found. Start by creating one!
                        </div>
                        
                        <table v-else class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 uppercase text-sm font-bold tracking-wider">
                                    <th class="p-4 border-b">Title</th>
                                    <th class="p-4 border-b">Deadline</th>
                                    <th class="p-4 border-b">Status</th>
                                    <th class="p-4 border-b text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="rfq in rfqs" :key="rfq.id" class="hover:bg-gray-50 transition border-b">
                                    <td class="p-4 font-semibold text-gray-800">{{ rfq.title }}</td>
                                    <td class="p-4 text-gray-600">{{ new Date(rfq.deadline).toLocaleDateString() }}</td>
                                    <td class="p-4">
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold uppercase">{{ rfq.status }}</span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <Link :href="route('rfqs.show', rfq.id)" class="text-blue-600 hover:text-blue-800 font-bold px-2">
                                            View
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