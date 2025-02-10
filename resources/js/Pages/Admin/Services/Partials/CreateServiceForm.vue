<script setup>
import { useForm } from "@inertiajs/vue3";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
  serviceCategories: Array,
});

const form = useForm({
  name: "",
  price: "",
  description: "",
  service_category_id: "",
});

const createService = () => {
  form.post(route("services.store"), {
    errorBag: "createService",
    preserveScroll: true,
  });
};
</script>
<template>
  <FormSection @submitted="createService">
    <template #title> Service Information </template>

    <template #description> Create a new service or product for the hotel. </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="name" value="Service Name" />
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
        <InputLabel for="price" value="Price" />
        <TextInput
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
      <PrimaryButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Create
      </PrimaryButton>
    </template>
  </FormSection>
</template>
