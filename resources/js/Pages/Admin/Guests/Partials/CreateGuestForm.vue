<script setup>
import { useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import countries from '@/countries';

const listOfCountries = reactive(countries);

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    nationality: 'Philippines (the)',
});

const createGuest = () => {
    form.post(route('guests.store'), {
        errorBag: 'createGuest',
        preserveScroll: true,
    });
};
</script>
<template>
  <FormSection @submitted="createGuest">
      <template #title>
          Guest Information
      </template>

      <template #description>
          Create a new guest to be able to create new bookings for hotel rooms.
      </template>

      <template #form>
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
                id="nationality">
                <option v-for="country in listOfCountries" :value="country">{{ country }}</option>
              </select>
              <InputError :message="form.errors.nationality" class="mt-2" />
          </div>
      </template>

      <template #actions>
          <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Create
          </PrimaryButton>
      </template>
  </FormSection>
</template>
