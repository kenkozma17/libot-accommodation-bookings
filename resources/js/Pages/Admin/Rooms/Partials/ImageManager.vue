<script setup>
import FormSection from "@/Components/FormSection.vue";
import { ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { useToast } from "vue-toast-notification";

const $toast = useToast({
    position: "top-right",
});

const props = defineProps({
    room: Object,
});

const form = useForm({
    images: props.room.images ?? [],
});

const imageForm = useForm({});
const fileInputRef = ref(null);

const handleFileUpload = (event) => {
    const files = event.target.files;
    form.images = Array.from(files);
};

const uploadImages = () => {
    form.post(route("rooms.upload-image", props.room.id), {
        errorBag: "imageUpload",
        preserveScroll: true,
        onSuccess: () => {
            $toast.success("Image/s uploaded successfully!");
            fileInputRef.value.value = "";
        },
    });
};

const removeImage = (imageId) => {
    imageForm.delete(route("rooms.delete-image", imageId), {
        errorBag: "imageDelete",
        preserveScroll: true,
        onSuccess: () => {
            const imageIndex = form.images.findIndex(
                (image) => image.id === imageId
            );
            form.images.splice(imageIndex, 1);
            $toast.success("Image removed successfully!");
        },
    });
};

const setPrimaryImage = (image) => {
    imageForm.post(route("rooms.set-primary-image", image.id), {
        errorBag: "setPrimary",
        preserveScroll: true,
    });
};

const isPrimaryImage = (image) => {
    return image.is_primary;
};
</script>
<template>
    <FormSection @submitted="uploadImages">
        <template #title> Image Manager </template>

        <template #description>
            Upload, view and remove images of this hotel room.
        </template>

        <template #form>
            <!-- Image management (Delete, Sort, Mark as primary) -->
            <div class="col-span-6">
                <InputLabel for="images" value="Image Gallery" />
                <div
                    class="grid grid-cols-3 gap-4 mt-2 items-start"
                    v-if="room.images.length"
                >
                    <div
                        class="relative col-span-1 border-2 border-gray rounded p-2 drop-shadow"
                        v-for="image in room.images"
                    >
                        <div
                            @click="removeImage(image.id)"
                            class="cursor-pointer absolute top-0 right-0"
                        >
                            <svg
                                class="hover:bg-gray-300 h-5 w-5 text-black border-black border rounded bg-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </div>
                        <img :src="image.image_url_path" alt="" />
                        <PrimaryButton
                            type="button"
                            class="absolute bottom-2 left-2 text-[10px] px-1 py-1 font-semibold"
                            @click="setPrimaryImage(image)"
                        >
                            {{
                                isPrimaryImage(image)
                                    ? "Primary"
                                    : "Make Primary"
                            }}
                        </PrimaryButton>
                    </div>
                </div>
                <div v-else>
                    <p class="text-sm mt-2">No Images Found</p>
                </div>
            </div>

            <!-- Uploader -->
            <div class="col-span-6 sm:col-span-4">
                <input
                    ref="fileInputRef"
                    type="file"
                    multiple
                    @change="handleFileUpload"
                />
            </div>
        </template>

        <template #actions>
            <SecondaryButton @click="form.reset()">
                {{ isReadOnly ? "Edit" : "Cancel" }}
            </SecondaryButton>
            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                class="ml-2"
                :disabled="form.processing"
            >
                Upload
            </PrimaryButton>
        </template>
    </FormSection>
</template>
