<script setup>
import FormSection from '@/Components/FormSection.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
  bookings: Array,
});
</script>
<template>
  <FormSection>
      <template #title>
          Guest Bookings
      </template>

      <template #description>
          A list of previous or current bookings of a guest.
      </template>

      <template #form>
        <div v-if="bookings.length > 0" class="col-span-6">
          <h3 class="text-lg font-medium text-gray-900">
            Bookings
          </h3>
          <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
            <button
              v-for="(booking, i) in bookings"
              type="button"
              :class="{'border-t border-gray-200 focus:border-none rounded-t-none': i > 0, 'rounded-b-none': i != Object.keys(bookings).length - 1}"
              class="hover:bg-gray-100 relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
              <div class="w-full">
                  <div class="flex items-center justify-between">
                      <div class="text-sm text-gray-600">
                          Confirmation #: {{ booking.booking_confirmation }}
                      </div>
                      <div class="text-xs text-gray-600">
                          {{ booking.created_at_formatted }}
                      </div>
                  </div>

                  <div class="mt-2 text-xs text-gray-600 text-left">
                      {{ booking.check_in_formatted }} - {{ booking.check_out_formatted }}
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
