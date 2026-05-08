<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    vendors: Array,
});

const form = useForm({
    name: '',
    email: '',
    company: '',
});

const submit = () => {
    form.post(route('vendors.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Vendor Management" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Vendor Management</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 border-t-4 border-green-500">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Add New Vendor</h3>
                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <InputLabel for="name" value="Contact Name *" />
                                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                            <div>
                                <InputLabel for="email" value="Email Address *" />
                                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>
                            <div>
                                <InputLabel for="company" value="Vendor Company *" />
                                <TextInput id="company" type="text" class="mt-1 block w-full" v-model="form.company" required />
                                <InputError class="mt-2" :message="form.errors.company" />
                            </div>
                            <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-md font-bold hover:bg-green-700 transition" :disabled="form.processing">
                                Save Vendor
                            </button>
                        </form>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Vendor Directory</h3>
                        
                        <div v-if="vendors.length === 0" class="text-center py-8 text-gray-500 bg-gray-50 rounded-md border border-dashed border-gray-300">
                            No vendors in the database. Add your first one!
                        </div>
                        
                        <table v-else class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 uppercase text-xs font-bold tracking-wider">
                                    <th class="p-3 border-b">Company</th>
                                    <th class="p-3 border-b">Contact</th>
                                    <th class="p-3 border-b">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="vendor in vendors" :key="vendor.id" class="hover:bg-gray-50 border-b text-sm">
                                    <td class="p-3 font-semibold text-gray-800">{{ vendor.company }}</td>
                                    <td class="p-3 text-gray-600">{{ vendor.name }}</td>
                                    <td class="p-3 text-blue-600">{{ vendor.email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>