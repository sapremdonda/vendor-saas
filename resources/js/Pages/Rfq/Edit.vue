<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    rfq: Object,
});

const form = useForm({
    title: props.rfq.title,
    description: props.rfq.description,
    items_required: props.rfq.items_required || '',
    deadline: props.rfq.deadline,
    status: props.rfq.status,
});

const submit = () => {
    form.put(route('rfqs.update', props.rfq.id));
};
</script>

<template>
    <Head title="Edit RFQ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit RFQ: {{ rfq.title }}</h2>
                <Link :href="route('rfqs.show', rfq.id)" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md font-bold hover:bg-gray-300 transition">
                    Cancel
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-8 border-t-4 border-yellow-500">
                    <form @submit.prevent="submit" class="space-y-6">
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 sm:col-span-1">
                                <InputLabel for="title" value="RFQ Title *" />
                                <TextInput id="title" type="text" class="mt-1 block w-full" v-model="form.title" required />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <InputLabel for="status" value="Project Status *" />
                                <select id="status" v-model="form.status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="Active">Active (Accepting Bids)</option>
                                    <option value="Reviewing">Reviewing Quotes</option>
                                    <option value="Awarded">Awarded / Closed</option>
                                    <option value="Archived">Archived / Cancelled</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.status" />
                            </div>
                        </div>

                        <div>
                            <InputLabel for="description" value="Description *" />
                            <textarea id="description" v-model="form.description" required class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4"></textarea>
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>

                        <div>
                            <InputLabel for="items_required" value="Items/Services Required" />
                            <textarea id="items_required" v-model="form.items_required" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3"></textarea>
                            <InputError class="mt-2" :message="form.errors.items_required" />
                        </div>

                        <div>
                            <InputLabel for="deadline" value="Submission Deadline *" />
                            <TextInput id="deadline" type="date" class="mt-1 block w-full" v-model="form.deadline" required />
                            <InputError class="mt-2" :message="form.errors.deadline" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded-md font-bold hover:bg-yellow-600 transition" :disabled="form.processing">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>