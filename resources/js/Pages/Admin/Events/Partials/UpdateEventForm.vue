<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
  event: Object,
  isDisabled: {
    type: Boolean,
    default: false,
  },
});

const isReadOnly = ref(true);

function resetForm() {
  isReadOnly.value = !isReadOnly.value;
  form.reset();
}

const form = useForm({
  name: props.event.name,
  type: props.event.type,
  pax: props.event.pax,
  setup_time: props.event.setup_time,
  start_time: props.event.start_time,
  end_time: props.event.end_time,
  serving_time: props.event.serving_time,
  start_date: props.event.start_date,
  end_date: props.event.end_date,
  notes: props.event.notes,
  status: props.event.status,
  guest_id: props.event.guest_id
});

const updateEvent = () => {
  form.put(route("events.update", props.event.id), {
    errorBag: "updateEvent",
    preserveScroll: true,
  });
};
</script>
<template>
  <FormSection @submitted="updateEvent">
    <template #title> Event Information </template>

    <template #description> Update an Event. </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="guest" value="Guest Name" />
        <a :href="'/guests/' + props.event.guest.id">{{props.event.guest.full_name + ' - ' + props.event.guest.email}}</a>
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="type" value="Type" />
        <TextInput
          required
          id="type"
          v-model="form.type"
          :disabled="isReadOnly"
          :class="{ 'bg-gray-100': isReadOnly }"
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
          :disabled="isReadOnly"
          :class="{ 'bg-gray-100': isReadOnly }"
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
          :disabled="isReadOnly"
          :class="{ 'bg-gray-100': isReadOnly }"
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
          :disabled="isReadOnly"
          :class="{ 'bg-gray-100': isReadOnly }"
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
          :disabled="isReadOnly"
          :class="{ 'bg-gray-100': isReadOnly }"
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
          :disabled="isReadOnly"
          :class="{ 'bg-gray-100': isReadOnly }"
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
          :disabled="isReadOnly"
          :class="{ 'bg-gray-100': isReadOnly }"
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
          :disabled="isReadOnly"
          :class="{ 'bg-gray-100': isReadOnly }"
          type="time"
          step="60"
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
          :disabled="isReadOnly"
          :class="{ 'bg-gray-100': isReadOnly }"
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
          :disabled="isReadOnly"
          :class="{ 'bg-gray-100': isReadOnly }"
          name="status"
          id="status"
        >
          <option value="" disabled selected>Select Status</option>
          <option value="COMPLETED">COMPLETED</option>
          <option value="CONFIRMED">CONFIRMED</option>
          <option value="PENDING">PENDING</option>
        </select>
        <InputError :message="form.errors.status" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <SecondaryButton :disabled="props.isDisabled" @click="resetForm">
        {{ isReadOnly ? "Edit" : "Cancel" }}
      </SecondaryButton>
      <PrimaryButton
        v-if="!isReadOnly"
        class="ml-2"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Save
      </PrimaryButton>
    </template>
  </FormSection>
</template>
