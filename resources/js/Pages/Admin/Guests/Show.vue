<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import UpdateGuestForm from '@/Pages/Admin/Guests/Partials/UpdateGuestForm.vue';
import GuestBookings from '@/Pages/Admin/Guests/Partials/GuestBookings.vue';
import GuestPayments from '@/Pages/Admin/Guests/Partials/GuestPayments.vue';
import SectionBorder from '@/Components/SectionBorder.vue';

const props = defineProps({
  guest: Object,
});
</script>

<template>
    <AppLayout :title="`Guest: ${guest.full_name}`">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Guest: {{ guest.full_name }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
              <UpdateGuestForm :guest="guest" />

              <template v-if="guest.bookings.length">
                <SectionBorder />
                
                <GuestBookings :bookings="guest.bookings" />
              </template>

              <template v-if="guest.payments.length">
                <SectionBorder />

                <GuestPayments :payments="guest.payments" />
              </template>
            </div>
        </div>
    </AppLayout>
</template>