<script setup>
import { useForm } from "@inertiajs/vue3";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({

});

const form = useForm({
  name: "",
  type: "",
  notes: "",
});

const createEventSet = () => {
  form.post(route("event-sets.store"), {
    errorBag: "createEventSet",
    preserveScroll: true,
  });
};
</script>
<template>
  <FormSection @submitted="createEventSet">
    <template #title> Event Set Information </template>

    <template #description> Create a new Event Set item for the hotel. </template>

    <template #form>
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
