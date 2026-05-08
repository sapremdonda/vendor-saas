<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    title: '',
    description: '',
    items_required: '',
    deadline: '',
});

const submit = () => {
    form.post(route('rfqs.store'));
};
</script>

<template>
    <Head title="Create RFQ" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create New RFQ</h2>
        </template>

        <div class="py-12"> 
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-8 border-t-4 border-blue-600">
                    <form @submit.prevent="submit" class="space-y-6">
                        
                        <div>
                            <InputLabel for="title" value="RFQ Title *" />
                            <TextInput id="title" type="text" class="mt-1 block w-full" v-model="form.title" required autofocus />
                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>

                        <div>
                            <InputLabel for="description" value="Description *" />
                            <textarea id="description" v-model="form.description" required class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4"></textarea>
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>

                        <div>
                            <InputLabel for="items_required" value="Items/Services Required" />
                            <textarea id="items_required" v-model="form.items_required" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" placeholder="List item specifics, quantities, etc."></textarea>
                            <InputError class="mt-2" :message="form.errors.items_required" />
                        </div>

                        <div>
                            <InputLabel for="deadline" value="Submission Deadline *" />
                            <TextInput id="deadline" type="date" class="mt-1 block w-full" v-model="form.deadline" required />
                            <InputError class="mt-2" :message="form.errors.deadline" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md font-bold hover:bg-blue-700 transition" :disabled="form.processing">
                                Create RFQ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>