<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateInventoryMovementForm from '@/Pages/Admin/InventoryMovements/Partials/CreateInventoryMovementForm.vue';

const props = defineProps({
  items: Array,
  units: Array,
});
</script>

<template>
    <AppLayout title="Create An Inventory Transaction">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create An Inventory Transaction
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateInventoryMovementForm
                  :units="units" :items="items"
                  />
            </div>
        </div>
    </AppLayout>
</template>
