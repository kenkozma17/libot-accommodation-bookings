<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import UpdateBookingForm from '@/Pages/Admin/Bookings/Partials/UpdateBookingForm.vue';
import SectionBorder from '@/Components/SectionBorder.vue';

const props = defineProps({
  folio: Object,
});
</script>

<template>
    <AppLayout :title="`Folio: ${folio.registration_number}`">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Folio: {{ folio.registration_number }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
              <!-- <UpdateFolioForm :folio="folio" /> -->

              <!-- <SectionBorder /> -->

              <UpdateBookingForm :booking="folio.booking" v-if="folio.booking" />

              <AddTransactionForm />
            </div>
        </div>
    </AppLayout>
</template>
