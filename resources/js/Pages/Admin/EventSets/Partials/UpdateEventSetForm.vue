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
  set: Object,
  isDisabled: {
    type: Boolean,
    default: false,
  },
});

const isReadOnly = ref(true);

const form = useForm({
  name: props.set.name,
  type: props.set.type,
  notes: props.set.notes,
});

const updateEventSet = () => {
  form.put(route("event-sets.update", props.set.id), {
    errorBag: "updateEventSet",
    preserveScroll: true,
    onSuccess: () => (isReadOnly.value = true),
  });
};

const deleteEventSet = () => {
  const confirmDelete = confirm("Are you sure you want to delete this event set?");
  if (confirmDelete) {
    form.delete(route("event-sets.destroy", props.set.id), {
      errorBag: "deleteEventSet",
      preserveScroll: true,
    });
  }
};

function resetForm() {
  isReadOnly.value = !isReadOnly.value;
  form.reset();
}
</script>
<template>
  <FormSection @submitted="updateEventSet">
    <template #title> Event Set Information </template>

    <template #description> Update event set for the hotel. </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="name" value="Name" />
        <TextInput
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
      <SecondaryButton
        v-if="!isReadOnly"
        :disabled="props.isDisabled"
        @click="deleteEventSet"
      >
        Delete
      </SecondaryButton>
      <div>
        <SecondaryButton class="ml-2" :disabled="props.isDisabled" @click="resetForm">
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
      </div>
    </template>
  </FormSection>
</template>
