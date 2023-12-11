<script setup>
import { VueFinalModal } from "vue-final-modal";
import { defineEmits } from "vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Pagination } from "vue3-carousel";

const emit = defineEmits(["close", "selectRoom"]);
const props = defineProps({
    room: Object,
});
</script>

<template>
    <VueFinalModal
        class="flex justify-center items-center"
        content-class="flex flex-col w-[90%] h-[90%] mx-4 p-4 bg-white border space-y-2 overflow-auto"
    >
        <div class="grid grid-cols-2 py-3 md:p-10 px-2 relative h-full">
            <div
                @click="emit('close')"
                class="cursor-pointer transform hover:rotate-90 transition-transform rounded-full p-2 bg-white drop-shadow-lg absolute top-0 right-0"
            >
                <CloseIcon />
            </div>
            <div class="lg:col-span-1 col-span-2">
                <h2
                    class="md:text-[2.5rem] text-[1.5rem] font-bold tracking-wide leading-snug"
                >
                    {{ props.room.name }}
                </h2>
                <ul
                    v-if="props.room.size && props.room.beds"
                    class="flex md:mb-4 mb-2"
                >
                    <li class="font-bold md:text-[.85rem] text-[.75rem] pr-2">
                        {{ props.room.size_formatted }}
                    </li>
                    <li
                        class="font-bold md:text-[.85rem] text-[.75rem] border-l-2 border-black pr-2 pl-2"
                    >
                        {{ props.room.beds_formatted }}
                    </li>
                </ul>

                <div class="lg:hidden my-2">
                    <template v-if="room.images.length">
                        <Carousel :items-to-show="1">
                            <Slide
                                v-for="(image, key) in room.images"
                                :key="key"
                            >
                                <img
                                    :src="image.image_url_path"
                                    class="w-full"
                                />
                            </Slide>

                            <template #addons>
                                <Pagination />
                            </template>
                        </Carousel>
                    </template>
                    <template v-else>
                        <div class="flex items-center justify-center h-full">
                            <p class="text-[1.25rem] font-semibold">
                                No Available Room Images Yet.
                            </p>
                        </div>
                    </template>
                </div>

                <p
                    v-if="props.room.description"
                    class="md:text-[1rem] text-[.85rem]"
                >
                    {{ props.room.description }}
                </p>
                <div class="md:my-8 my-4">
                    <button
                        @click="emit('selectRoom')"
                        class="hover:bg-dark-green hover:text-white uppercase border-2 border-dark-green font-bold md:text-[1rem] text-[.85rem] md:p-2.5 p-2 w-full"
                    >
                        Book Now
                    </button>
                </div>
                <div v-if="props.room.amenities.length" class="my-8">
                    <h3
                        class="md:text-[1.25rem] text-[1rem] font-bold tracking-wide"
                    >
                        Hotel and Room Amenities
                    </h3>
                    <ul class="grid grid-cols-6 my-2">
                        <li
                            class="md:my-2 my-1 mx-1 xl:col-span-2 col-span-3 md:text-[1rem] text-[.85rem]"
                            v-for="amenity in props.room.amenities"
                        >
                            {{ amenity.name }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="lg:col-span-1 col-span-2 pl-8 h-full lg:block hidden">
                <template v-if="room.images.length">
                    <Carousel :items-to-show="1">
                        <Slide v-for="(image, key) in room.images" :key="key">
                            <img
                                :src="image.image_url_path"
                                class="w-full h-full"
                            />
                        </Slide>

                        <template #addons>
                            <Pagination />
                        </template>
                    </Carousel>
                </template>
                <template v-else>
                    <div class="flex items-center justify-center h-full">
                        <p class="text-[1.25rem] font-semibold">
                            No Available Room Images Yet.
                        </p>
                    </div>
                </template>
            </div>
        </div>
    </VueFinalModal>
</template>
