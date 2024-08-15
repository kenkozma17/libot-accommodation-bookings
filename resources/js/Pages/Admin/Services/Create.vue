<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateServiceForm from '@/Pages/Admin/Services/Partials/CreateServiceForm.vue';

const props = defineProps({
  serviceCategories: Array,
});
</script>

<template>
    <AppLayout title="Create Service">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Service
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateServiceForm
                  :serviceCategories="serviceCategories"
                  />
            </div>
        </div>
    </AppLayout>
</template>
