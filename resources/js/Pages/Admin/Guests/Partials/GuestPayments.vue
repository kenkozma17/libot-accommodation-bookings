<script setup>
import FormSection from '@/Components/FormSection.vue';

const props = defineProps({
  payments: Array,
});
</script>
<template>
  <FormSection>
      <template #title>
          Guest Payments
      </template>

      <template #description>
          A list of previous or current payments of a guest.
      </template>

      <template #form>
        <div v-if="payments.length > 0" class="col-span-6">
          <h3 class="text-lg font-medium text-gray-900">
            Payments
          </h3>
          <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
            <button
              v-for="(payment, i) in payments"
              type="button"
              :class="{'border-t border-gray-200 focus:border-none rounded-t-none': i > 0, 'rounded-b-none': i != Object.keys(payments).length - 1}"
              class="hover:bg-gray-100 relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
              <div class="w-full">
                  <div class="flex items-center justify-between">
                      <div class="text-sm text-gray-600">
                          {{ payment.payment_amount_formatted }}
                      </div>
                      <div class="text-xs text-gray-600">
                          {{ payment.payment_date_formatted }}
                      </div>
                  </div>

                  <div class="mt-2 text-xs text-gray-600 text-left">
                      #{{ payment.transaction_id }}
                  </div>
              </div>
            </button>
          </div>
        </div>
      </template>

      <template #actions>
          
      </template>
  </FormSection>
</template>
