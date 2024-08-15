<script setup>
import { useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Checkbox from "@/Components/Checkbox.vue";
import TextInput from "@/Components/TextInput.vue";
import dayjs from "dayjs";

const props = defineProps({
  guests: Array,
  bookings: Array,
});

const hasBooking = ref(false);

const form = useForm({
  guest_id: 0,
  booking_id: 0,
});

const createFolio = () => {
  form.post(route("folios.store"), {
    errorBag: "createFolio",
    preserveScroll: true,
  });
};
</script>
<template>
  <FormSection @submitted="createFolio">
    <template #title> Folio Information </template>

    <template #description> Create a new Guest Folio. </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="amenities" value="Does the guest have a booking?" />
        <label class="flex items-center">
          <Checkbox @change="hasBooking = !hasBooking" />
          <span class="ml-2 text-sm text-gray-600"> No </span>
        </label>
      </div>
      <div class="col-span-6 sm:col-span-4" v-if="hasBooking == false">
        <InputLabel for="booking_id" value="Booking" />
        <select
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.booking_id"
          required
          name="booking_id"
          id="booking_id"
        >
          <option value="0" disabled selected>Select Booking</option>
          <option v-for="(booking, index) in props.bookings" :value="booking.id">
            {{ booking.booking_confirmation.toUpperCase() }} -
            {{ booking.guest.last_name }}, {{ booking.guest.first_name }}
          </option>
        </select>
        <InputError :message="form.errors.booking_id" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4" v-if="hasBooking">
        <InputLabel for="guest_id" value="Guest*" />
        <select
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.guest_id"
          required
          name="guest_id"
          id="guest_id"
        >
          <option value="0" disabled selected>Select Guest</option>
          <option v-for="(guest, index) in props.guests" :value="guest.id">
            {{ guest.last_name + ", " + guest.first_name + " - (" + guest.email + ")" }}
          </option>
        </select>
        <InputError :message="form.errors.guest_id" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <PrimaryButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Create
      </PrimaryButton>
    </template>
  </FormSection>
</template>
