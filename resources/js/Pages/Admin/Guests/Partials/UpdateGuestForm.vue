<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, reactive } from 'vue'; 
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import countries from '@/countries';

const props = defineProps({
  guest: Object,
  isDisabled: {
    type: Boolean,
    default: false,
  }
});

const isReadOnly = ref(true);
const listOfCountries = reactive(countries);

const form = useForm({
    id: props.guest.id,
    first_name: props.guest.first_name,
    last_name: props.guest.last_name,
    email: props.guest.email,
    phone: props.guest.phone,
    nationality: props.guest.nationality,
});

function resetForm() {
  isReadOnly.value = !isReadOnly.value;
  form.reset();
}

const updateGuest = () => {
    form.put(route('guests.update', props.guest.id), {
        errorBag: 'updateGuest',
        preserveScroll: true,
        onSuccess: () => isReadOnly.value = true,
    });
};
</script>
<template>
  <FormSection @submitted="updateGuest">
      <template #title>
          Guest Information
      </template>

      <template #description>
          The contact details and other useful information about a guest.
      </template>

      <template #form>
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="first_name" value="First Name" />
              <TextInput
                  :disabled="isReadOnly"
                  id="first_name"
                  v-model="form.first_name"
                  type="text"
                  class="block w-full mt-1"
                  :class="{'bg-gray-100': isReadOnly}"
                  autofocus
              />
              <InputError :message="form.errors.first_name" class="mt-2" />
          </div>
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="last_name" value="Last Name" />
              <TextInput
                  :disabled="isReadOnly"
                  id="last_name"
                  v-model="form.last_name"
                  type="text"
                  class="block w-full mt-1"
                  :class="{'bg-gray-100': isReadOnly}"
                  autofocus
              />
              <InputError :message="form.errors.last_name" class="mt-2" />
          </div>
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="email" value="Email" />
              <TextInput
                  :disabled="isReadOnly"
                  id="email"
                  v-model="form.email"
                  type="email"
                  class="block w-full mt-1"
                  :class="{'bg-gray-100': isReadOnly}"
                  autofocus
              />
              <InputError :message="form.errors.email" class="mt-2" />
          </div>
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="phone" value="Phone Number" />
              <TextInput
                  :disabled="isReadOnly"
                  id="phone"
                  v-model="form.phone"
                  type="tel"
                  class="block w-full mt-1"
                  :class="{'bg-gray-100': isReadOnly}"
                  autofocus
              />
              <InputError :message="form.errors.phone" class="mt-2" />
          </div>
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="nationality" value="Nationality" />
              <select 
                :disabled="isReadOnly"
                class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                :class="{'bg-gray-100': isReadOnly}"
                v-model="form.nationality"
                name="nationality"
                id="nationality">
                <option v-for="country in listOfCountries" :value="country">{{ country }}</option>
              </select>
              <InputError :message="form.errors.nationality" class="mt-2" />
          </div>
      </template>

      <template #actions>
          <SecondaryButton 
            :disabled="props.isDisabled"
            @click="resetForm">
            {{ isReadOnly ? 'Edit' : 'Cancel'}}
          </SecondaryButton>
          <PrimaryButton 
            v-if="!isReadOnly" 
            class="ml-2"
            :class="{ 'opacity-25': form.processing }" 
            :disabled="form.processing">
            Save
          </PrimaryButton>
      </template>
  </FormSection>
</template>
