<script setup>
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';

const form = useForm({
    name: '',
    rate: '',
    room_number: '',
    description: '',
    max_occupancy: '',
    is_available: false,
    status: 'Available',
    cover_image: '',
    size: 0,
    floor: 1,
    beds: 1,
});

const createRoom = () => {
    form.post(route('rooms.store'), {
        errorBag: 'createRoom',
        preserveScroll: true,
    });
};
</script>
<template>
  <FormSection @submitted="createRoom">
      <template #title>
          Room Information
      </template>

      <template #description>
          Create a new room to faciliate bookings by guests.
      </template>

      <template #form>
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="name" value="Room Name" />
              <TextInput
                  id="name"
                  v-model="form.name"
                  type="text"
                  class="block w-full mt-1"
                  autofocus
                  placeholder="Standard Room"
              />
              <InputError :message="form.errors.name" class="mt-2" />
          </div>
          
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="room_number" value="Room Number" />
              <TextInput
                  id="room_number"
                  v-model="form.room_number"
                  type="text"
                  class="block w-full mt-1"
                  autofocus
              />
              <InputError :message="form.errors.room_number" class="mt-2" />
          </div>

          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="rate" value="Room Rate/Night (PHP)" />
              <TextInput
                  id="rate"
                  v-model="form.rate"
                  type="number"
                  class="block w-full mt-1"
                  autofocus
              />
              <InputError :message="form.errors.rate" class="mt-2" />
          </div>

          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="description" value="Description" />
              <TextInput
                  id="description"
                  v-model="form.description"
                  type="text"
                  class="block w-full mt-1"
                  autofocus
                  placeholder="This room is.."
              />
              <InputError :message="form.errors.description" class="mt-2" />
          </div>

          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="max_occupancy" value="Max Occupancy" />
              <TextInput
                  id="max_occupancy"
                  v-model="form.max_occupancy"
                  type="number"
                  class="block w-full mt-1"
                  autofocus
              />
              <InputError :message="form.errors.max_occupancy" class="mt-2" />
          </div>

          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="status" value="Room Status" />
              <select 
                class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                v-model="form.status"
                name="status"
                id="status">
                <option value="Available">Available</option>
                <option value="Out of Service">Out of Service</option>
              </select>
              <InputError :message="form.errors.status" class="mt-2" />
          </div>

          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="size" value="Size (sq. m)" />
              <TextInput
                  id="size"
                  v-model="form.size"
                  type="number"
                  class="block w-full mt-1"
                  autofocus
                  placeholder="2"
              />
              <InputError :message="form.errors.size" class="mt-2" />
          </div>

          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="beds" value="Beds" />
              <TextInput
                  id="beds"
                  v-model="form.beds"
                  type="number"
                  class="block w-full mt-1"
                  autofocus
                  placeholder="2"
              />
              <InputError :message="form.errors.beds" class="mt-2" />
          </div>

          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="floor" value="Floor" />
              <TextInput
                  id="floor"
                  v-model="form.floor"
                  type="number"
                  class="block w-full mt-1"
                  autofocus
                  placeholder="2"
              />
              <InputError :message="form.errors.floor" class="mt-2" />
          </div>

          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="cover_image" value="Main Image" />
              <input type="file" @input="form.cover_image = $event.target.files[0]">
              <InputError :message="form.errors.cover_image" class="mt-2" />
          </div>

          <div class="col-span-6 sm:col-span-4">
              <label class="flex items-center">
                  <Checkbox v-model:checked="form.is_available" name="is_available" />
                  <span class="ml-2 text-sm text-gray-600">Is Room Public?</span>
              </label>
              <InputError :message="form.errors.is_available" class="mt-2" />
          </div>
      </template>

      <template #actions>
          <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Create
          </PrimaryButton>
      </template>
  </FormSection>
</template>
