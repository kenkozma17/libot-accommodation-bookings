<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';

const isReadOnly = ref(true);

const props = defineProps({
  room: Object,
});

const form = useForm({
    id: props.room.id,
    name: props.room.name,
    rate: props.room.rate,
    room_number: props.room.room_number,
    description: props.room.description,
    max_occupancy: props.room.max_occupancy,
    is_available: props.room.is_available,
    status: props.room.status,
    size: props.room.size,
    floor: props.room.floor,
    beds: props.room.beds,
});

function resetForm() {
  isReadOnly.value = !isReadOnly.value;
  form.reset();
}

const updateRoom = () => {
    form.put(route('rooms.update', props.room.id), {
        errorBag: 'updateRoom',
        preserveScroll: true,
    });
};
</script>
<template>
  <FormSection @submitted="updateRoom">
      <template #title>
          Room Information
      </template>

      <template #description>
          Create a new room to faciliate bookings by guests.
      </template>

      <template #image>
        <img 
          :src="room.cover_image_url" 
          alt=""
          class="w-full mt-4"
          >
      </template>

      <template #form>
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="name" value="Room Name" />
              <TextInput
                  :disabled="isReadOnly"
                  :class="{'bg-gray-100': isReadOnly}"
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
                  :disabled="isReadOnly"
                  :class="{'bg-gray-100': isReadOnly}"
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
                  :disabled="isReadOnly"
                  :class="{'bg-gray-100': isReadOnly}"
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
                  :disabled="isReadOnly"
                  :class="{'bg-gray-100': isReadOnly}"
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
                  :disabled="isReadOnly"
                  :class="{'bg-gray-100': isReadOnly}"
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
                :disabled="isReadOnly"
                :class="{'bg-gray-100': isReadOnly}"
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
                  :disabled="isReadOnly"
                  :class="{'bg-gray-100': isReadOnly}"
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
                  :disabled="isReadOnly"
                  :class="{'bg-gray-100': isReadOnly}"
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
                  :disabled="isReadOnly"
                  :class="{'bg-gray-100': isReadOnly}"
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
              <label class="flex items-center">
                  <Checkbox
                    :disabled="isReadOnly"
                    :class="{'bg-gray-100': isReadOnly}"
                     v-model:checked="form.is_available"
                      name="is_available" />
                  <span class="ml-2 text-sm text-gray-600">Is Room Public?</span>
              </label>
              <InputError :message="form.errors.is_available" class="mt-2" />
          </div>
      </template>

      <template #actions>
          <SecondaryButton 
            @click="resetForm">
            {{ isReadOnly ? 'Edit' : 'Cancel'}}
          </SecondaryButton>
          <PrimaryButton 
            v-if="!isReadOnly" 
            class="ml-2"
            :class="{ 'opacity-25': form.processing }" 
            :disabled="form.processing">
              Update
          </PrimaryButton>
      </template>
  </FormSection>
</template>
