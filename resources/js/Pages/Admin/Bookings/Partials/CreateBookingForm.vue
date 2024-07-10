<script setup>
import { useForm } from "@inertiajs/vue3";
import { reactive, computed } from "vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import dayjs from 'dayjs';
import countries from "@/countries";

const listOfCountries = reactive(countries);

const props = defineProps({
  rooms: Array,
});

const form = useForm({
  booking_confirmation: "",
  booking_date: "",
  check_in: "",
  check_out: "",
  total_price: "",
  room_id: "",
  rate_per_night: "",
  booking_status: "CONFIRMED",
  special_requests: "",
  adults_count: "",
  children_count: "",
  stay_length: 0,
  first_name: "",
  last_name: "",
  email: "",
  phone: "",
  nationality: "Philippines (the)",
});

const stayCount = computed(() => {
    if(form.check_in && form.check_out) {
        const checkIn = dayjs(form.check_in);
        const checkOut = dayjs(form.check_out);

        return checkOut.diff(checkIn, 'day');
    }
    return 0;
});

const createBooking = () => {
    form.stay_length = stayCount;
    form.total_price = form.stay_length * Number(form.rate_per_night);
    form.post(route('bookings.store'), {
        errorBag: 'createBooking',
        preserveScroll: true,
    });
};

</script>
<template>
  <FormSection @submitted="createBooking">
    <template #title> Booking Information </template>

    <template #description> Create a new hotel booking. </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="booking_confirmation" value="Booking Confirmation" />
        <TextInput
          id="booking_confirmation"
          v-model="form.booking_confirmation"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.booking_confirmation" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="booking_date" value="Booking Date" />
        <TextInput
          id="date_placed"
          v-model="form.booking_date"
          type="date"
          class="block w-full mt-1"
          autofocus
        />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="check_in" value="Check In Date" />
        <TextInput
          id="check_in"
          v-model="form.check_in"
          type="date"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.check_in" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="check_out" value="Check Out Date" />
        <TextInput
          id="check_out"
          v-model="form.check_out"
          type="date"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.check_out" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="room_id" value="Room" />
        <select
            class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            v-model="form.room_id"
            name="room_id"
            id="room_id">
            <option value="" disabled selected>Select Room</option>
            <option
            v-for="room, index in props.rooms"
            :value="room.id">
            {{ room.full_room_name }}
            </option>
        </select>
        <InputError :message="form.errors.room_id" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="rate_per_night" value="Rate (Per Night PHP)" />
        <TextInput
          id="rate_per_night"
          v-model="form.rate_per_night"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.rate_per_night" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="adults_count" value="Adult(s)" />
        <TextInput
          id="adults_count"
          v-model="form.adults_count"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.adults_count" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="children_count" value="Children" />
        <TextInput
          id="children_count"
          v-model="form.children_count"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.children_count" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="special_requests" value="Special Requests" />
        <textarea
          id="special_requests"
          v-model="form.special_requests"
          type="text"
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          autofocus
        ></textarea>
        <InputError :message="form.errors.special_requests" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <p class="font-medium">Guest Information</p>
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="first_name" value="First Name" />
        <TextInput
          id="first_name"
          v-model="form.first_name"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.first_name" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="last_name" value="Last Name" />
        <TextInput
          id="last_name"
          v-model="form.last_name"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.last_name" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="email" value="Email" />
        <TextInput
          id="email"
          v-model="form.email"
          type="email"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.email" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="phone" value="Phone Number" />
        <TextInput
          id="phone"
          v-model="form.phone"
          type="tel"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.phone" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="nationality" value="Nationality" />
        <select
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.nationality"
          name="nationality"
          id="nationality"
        >
          <option v-for="country in listOfCountries" :value="country">
            {{ country }}
          </option>
        </select>
        <InputError :message="form.errors.nationality" class="mt-2" />
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
