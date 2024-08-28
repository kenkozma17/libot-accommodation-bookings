<script setup>
  import AppLayout from '@/Layouts/AppLayout.vue';
  import CreateReportForm from '@/Pages/Admin/Reports/Partials/CreateReportForm.vue'
</script>
<template>
  <AppLayout title="Report Management">
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Monthly Cash Flow Reports
        </h2>
    </template>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <CreateReportForm />
            </div>
        </div>
    </div>
  </AppLayout>
</template>
