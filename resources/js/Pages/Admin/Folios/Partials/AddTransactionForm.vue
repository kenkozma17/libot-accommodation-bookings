<script setup>
import { useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    folio: Object
});

const form = useForm({
    folio_id: '',
    quantity: '',
    price: '',
    amount: '',
    type: '',
    description: '',
    payment_method: '',
});

const createFolioTransaction = () => {
    form.post(route('folio-transactions.store'), {
        errorBag: 'createFolioTransaction',
        preserveScroll: true,
    });
};
</script>
<template>
  <FormSection @submitted="createFolioTransaction">
      <template #title>
          Folio Transaction
      </template>

      <template #description>
          Create a new income transaction on a Guest's Folio.
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
      </template>

      <template #actions>
          <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Create
          </PrimaryButton>
      </template>
  </FormSection>
</template>
