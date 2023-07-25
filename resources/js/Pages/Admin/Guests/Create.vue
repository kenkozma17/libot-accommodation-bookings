<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateGuestForm from '@/Pages/Admin/Guests/Partials/CreateGuestForm.vue';
</script>

<template>
    <AppLayout title="Create Guest">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Guest
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateGuestForm />
            </div>
        </div>
    </AppLayout>
</template>
