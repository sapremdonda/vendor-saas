<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

defineProps({ vendors: Array });
const form = useForm({ name: '', email: '', company: '' });
const submit = () => form.post(route('vendors.store'), { onSuccess: () => form.reset() });
</script>

<template>
    <Head title="Vendors" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-slate-900 leading-tight">Vendor Directory</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 shadow-sm rounded-lg border-t-4 border-blue-600">
                    <h3 class="font-bold mb-4">Add Vendor</h3>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <InputLabel value="Company Name" />
                            <TextInput v-model="form.company" class="w-full mt-1" required />
                        </div>
                        <div>
                            <InputLabel value="Contact Name" />
                            <TextInput v-model="form.name" class="w-full mt-1" required />
                        </div>
                        <div>
                            <InputLabel value="Email" />
                            <TextInput type="email" v-model="form.email" class="w-full mt-1" required />
                        </div>
                        <button class="w-full bg-slate-900 text-white py-2 rounded font-bold hover:bg-blue-600 transition">Save</button>
                    </form>
                </div>

                <div class="md:col-span-2 bg-white shadow-sm rounded-lg overflow-hidden border-t-4 border-slate-900">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-900 text-white text-xs uppercase font-bold">
                                <th class="p-4">Company</th>
                                <th class="p-4">Contact</th>
                                <th class="p-4">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="v in vendors" class="border-b text-sm hover:bg-gray-50">
                                <td class="p-4 font-bold">{{ v.company }}</td>
                                <td class="p-4">{{ v.name }}</td>
                                <td class="p-4 text-blue-600 underline">{{ v.email }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>