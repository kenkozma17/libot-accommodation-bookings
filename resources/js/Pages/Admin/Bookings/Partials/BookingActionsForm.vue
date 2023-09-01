<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const isReadOnly = ref(true);
const arrivalStatuses = reactive([
  'ON-SCHEDULE',
  'CHECKED-IN',
  'CHECKED-OUT',
  'NO-SHOW'
]);

const props = defineProps({
  booking: Object,
});

const form = useForm({
    id: props.booking.id,
    arrival_status: props.booking.arrival_status
});

const updateBooking = () => {
    form.put(route('bookings.update', props.booking.id), {
        errorBag: 'updateBooking',
        preserveScroll: true,
    });
};
</script>
<template>
  <FormSection @submitted="updateBooking">
      <template #title>
          Booking Actions
      </template>

      <template #description>
          Mark booking as checked-in, checked-out or no-show.
      </template>

      <template #form>
        <div class="col-span-6 sm:col-span-4">
            <InputLabel for="arrival_status" value="Arrival Status" />
            <select 
              class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
              v-model="form.arrival_status"
              name="arrival_status"
              id="arrival_status">
              <option 
                v-for="status in arrivalStatuses" 
                :value="status">
                {{ status }}
              </option>
            </select>
            <InputError :message="form.errors.arrival_status" class="mt-2" />
        </div>
      </template>

      <template #actions>
        <PrimaryButton 
            class="ml-2"
            :class="{ 'opacity-25': form.processing }" 
            :disabled="form.processing">
              Update
          </PrimaryButton>
      </template>
  </FormSection>
</template>