<script setup>
import { useForm } from "@inertiajs/vue3";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
  guests: Array,
});

const form = useForm({
  name: "",
  type: "",
  pax: "",
  setup_time: "",
  start_time: "",
  end_time: "",
  serving_time: "",
  start_date: "",
  end_date: "",
  notes: "",
  status: "",
  guest_id: ""
});

const createEvent = () => {
  form.post(route("events.store"), {
    errorBag: "createEvent",
    preserveScroll: true,
  });
};
</script>
<template>
  <FormSection @submitted="createEvent">
    <template #title> Event Information </template>

    <template #description> Create a new Event. </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="guest_id" value="Guests" />
        <select
            class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            v-model="form.guest_id"
            name="guest_id"
            id="guest_id">
            <option value="" disabled selected>Select Guest</option>
            <option
            v-for="guest in props.guests"
            :value="guest.id">
            {{ guest.last_name }}, {{ guest.first_name }} - {{ guest.email }}
            </option>
        </select>
        <InputError :message="form.errors.guest_id" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="name" value="Name" />
        <TextInput
          required
          id="name"
          v-model="form.name"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.name" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="type" value="Type" />
        <TextInput
          required
          id="type"
          v-model="form.type"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.type" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="pax" value="Pax" />
        <TextInput
          required
          id="pax"
          v-model="form.pax"
          type="number"
          min="1"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.pax" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="start_date" value="Start Date" />
        <TextInput
          required
          id="start_date"
          v-model="form.start_date"
          type="date"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.start_date" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="end_date" value="End Date" />
        <TextInput
          required
          id="end_date"
          v-model="form.end_date"
          type="date"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.end_date" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="start_time" value="Start Time" />
        <TextInput
          required
          id="start_time"
          v-model="form.start_time"
          type="time"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.start_time" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="setup_time" value="Setup Time" />
        <TextInput
          required
          id="setup_time"
          v-model="form.setup_time"
          type="time"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.setup_time" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="serving_time" value="Serving Time" />
        <TextInput
          required
          id="serving_time"
          v-model="form.serving_time"
          type="time"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.serving_time" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="end_time" value="End Time" />
        <TextInput
          required
          id="end_time"
          v-model="form.end_time"
          type="time"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.end_time" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="notes" value="Notes" />
        <textarea
          id="notes"
          v-model="form.notes"
          type="text"
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          autofocus
        ></textarea>
        <InputError :message="form.errors.notes" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="status" value="Status" />
        <select
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.status"
          name="status"
          id="status"
        >
          <option value="" disabled selected>Select Status</option>
          <option value="CONFIRMED">CONFIRMED</option>
          <option value="PENDING">PENDING</option>
        </select>
        <InputError :message="form.errors.status" class="mt-2" />
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
