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
  service: Object,
  serviceCategories: Array,
  isDisabled: {
    type: Boolean,
    default: false,
  },
});

const isReadOnly = ref(true);

const form = useForm({
  name: props.service.name,
  price: props.service.price,
  description: props.service.description,
  service_category_id: props.service.service_category_id,
});

const updateService = () => {
  form.put(route("services.update", props.service.id), {
    errorBag: "updateService",
    preserveScroll: true,
    onSuccess: () => (isReadOnly.value = true),
  });
};

const deleteService = () => {
  const confirmDelete = confirm("Are you sure you want to delete this service?");
  if (confirmDelete) {
    form.delete(route("services.destroy", props.service.id), {
      errorBag: "deleteService",
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
  <FormSection @submitted="updateService">
    <template #title> Service Information </template>

    <template #description> Update a new service or product for the hotel. </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="name" value="Service Name" />
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
        <InputLabel for="price" value="Price" />
        <TextInput
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
          required
          id="price"
          v-model="form.price"
          type="number"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.price" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="description" value="Description" />
        <textarea
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
          id="description"
          v-model="form.description"
          type="text"
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          autofocus
        ></textarea>
        <InputError :message="form.errors.description" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="category" value="Category" />
        <select
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
          required
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.service_category_id"
          name="category"
          id="category"
        >
          <option value="" disabled>Select a Service</option>
          <option v-for="category in serviceCategories" :value="category.id">
            {{ category.name }}
          </option>
        </select>
        <InputError :message="form.errors.category" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <!-- <SecondaryButton
        class="bg-red-500 text-white hover:bg-red-400"
        v-if="!isReadOnly"
        :disabled="props.isDisabled"
        @click="deleteService"
      >
        Delete
      </SecondaryButton> -->
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
    </template>
  </FormSection>
</template>
