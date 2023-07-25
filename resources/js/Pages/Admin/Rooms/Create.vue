<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateRoomForm from '@/Pages/Admin/Rooms/Partials/CreateRoomForm.vue';
</script>

<template>
    <AppLayout title="Create Room">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Room
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateRoomForm />
            </div>
        </div>
    </AppLayout>
</template>
