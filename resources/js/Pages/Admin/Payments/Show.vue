<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import UpdatePaymentForm from '@/Pages/Admin/Payments/Partials/UpdatePaymentForm.vue';

const props = defineProps({
  payment: Object,
});
</script>

<template>
    <AppLayout :title="`Payment: ${payment.paymongo_payment_id}`">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Payment: {{ payment.paymongo_payment_id }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
              <UpdatePaymentForm :payment="payment" />
            </div>
        </div>
    </AppLayout>
</template>