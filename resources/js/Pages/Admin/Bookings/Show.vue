<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import UpdateBookingForm from '@/Pages/Admin/Bookings/Partials/UpdateBookingForm.vue';
import UpdateGuestForm from '@/Pages/Admin/Guests/Partials/UpdateGuestForm.vue';
import UpdatePaymentForm from '@/Pages/Admin/Payments/Partials/UpdatePaymentForm.vue';
import BookingActionsForm from '@/Pages/Admin/Bookings/Partials/BookingActionsForm.vue';
import SectionBorder from '@/Components/SectionBorder.vue';

const props = defineProps({
  booking: Object,
});
</script>

<template>
    <AppLayout :title="`Booking: ${booking.booking_confirmation}`">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Booking: {{ booking.booking_confirmation }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
              <BookingActionsForm :booking="booking" />

              <SectionBorder />

              <UpdateBookingForm :booking="booking" />

              <SectionBorder />
              
              <UpdateGuestForm 
                :guest="booking.guest"
                :is-disabled="true"
                />

              <SectionBorder />

              <UpdatePaymentForm
                :payment="booking.payment"
                />
            </div>
        </div>
    </AppLayout>
</template>