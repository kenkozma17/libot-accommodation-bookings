<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateInventoryForm from '@/Pages/Admin/Inventory/Partials/CreateInventoryForm.vue';

const props = defineProps({
  categories: Array,
  units: Array,
});
</script>

<template>
    <AppLayout title="Create Inventory">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Inventory
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateInventoryForm
                  :categories="categories"
                  :units="units"
                  />
            </div>
        </div>
    </AppLayout>
</template>
