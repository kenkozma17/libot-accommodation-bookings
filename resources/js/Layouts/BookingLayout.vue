<script setup>
  import Navigator from '@/Components/Booking/Navigator.vue';
  import DetailsPanel from '@/Components/Booking/DetailsPanel.vue';
  import { ModalsContainer } from 'vue-final-modal';
  import { Link } from '@inertiajs/vue3';
  import ApplicationMark from '@/Components/ApplicationMark.vue';
</script>
<template>
  <div class="max-w-7xl mx-auto">
    <div class="m-4">
      <div class="flex justify-center md:my-6 my-3">
        <Link href="/">
          <ApplicationMark class="md:w-60 w-40" />
        </Link>
      </div>
      <ModalsContainer />
      <Navigator></Navigator>
      <DetailsPanel class="my-4"></DetailsPanel>
      <div>
        <slot></slot>
      </div>
    </div>
    <div
      v-if="$page.props.auth.user" 
      class="fixed top-0 right-0 bg-white border 
        border-l-black border-b-black 
        rounded-tl-none rounded-br-none rounded-md md:px-4 px-2 md:py-2 py-1">
      <Link
        class="text-black font-semibold decoration-inherit md:text-[1rem] text-[.75rem]"
        href="/dashboard">
          <span>Dashboard</span>
      </Link>
    </div>
    <div v-else>
      
    </div>
  </div>
</template>