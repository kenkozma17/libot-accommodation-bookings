<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import AddTransactionForm from "@/Pages/Admin/FolioTransactions/Partials/AddTransactionForm.vue";
import UpdateBookingForm from "@/Pages/Admin/Bookings/Partials/UpdateBookingForm.vue";
import UpdateGuestForm from "@/Pages/Admin/Guests/Partials/UpdateGuestForm.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import FolioTransactionsList from "./Partials/FolioTransactionsList.vue";

const props = defineProps({
  folio: Object,
  serviceCategories: Array,
});
</script>

<template>
  <AppLayout :title="`Folio: ${folio.registration_number}`">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Guest Folio (Registration No: {{ folio.registration_number }})
      </h2>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <!-- <UpdateFolioForm :folio="folio" /> -->

        <AddTransactionForm :folio="folio" :serviceCategories="serviceCategories" />

        <SectionBorder />

        <FolioTransactionsList :folio="folio" />

        <SectionBorder />

        <UpdateGuestForm
          v-if="folio.booking"
          :guest="folio.booking.guest"
          :is-disabled="true"
        />

        <UpdateGuestForm
          v-else
          :guest="folio.guest"
          :is-disabled="true"
        />

        <SectionBorder />

        <UpdateBookingForm :booking="folio.booking" v-if="folio.booking" />
      </div>
    </div>
  </AppLayout>
</template>
