<script setup>
import axios from "axios";
import { reactive, watch, computed, ref } from "vue";
import { router } from "@inertiajs/vue3";
import Editor from "@tinymce/tinymce-vue";
import ResetObject from "@/Utilities/resetObject";

const props = defineProps({
    post_types: {
        type: Array,
    },
});

console.log(props);

const errors = reactive({});
const postForm = reactive({
    post_name: null,
    post_image: null,
    post_content: null,
    post_type: null,
});

const postImageUrl = computed(() => {
    const file = postForm.post_image;
    return file ? URL.createObjectURL(file) : null;
});

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    delete errors.post_image;

    if (file && file.size <= 10000000 && file.type.startsWith("image")) {
        const img = new Image();
        const objectUrl = URL.createObjectURL(file);

        img.onload = () => {
            if (img.width >= 800 && img.height >= 600) {
                postForm.post_image = file;
            } else {
                errors.post_image = "Obrazek jest za mały";
            }
            URL.revokeObjectURL(objectUrl);
        };

        img.src = objectUrl;
    } else if (file.size > 10000000) {
        errors.post_image = "Obrazek jest za duży";
    } else if (!file.type.startsWith("image")) {
        errors.post_image = "Plik nie jest obrazem";
    }
};

const HandleEditorImage = () => (blobInfo, progress) => {
    const formData = new FormData();
    formData.append("image", blobInfo.blob(), blobInfo.filename());

    return axios
        .post(route("blog-create.image"), formData, {
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                "Content-Type": "multipart/form-data",
            },
            onUploadProgress: (progressEvent) => {
                if (progressEvent.lengthComputable) {
                    progress(
                        (progressEvent.loaded / progressEvent.total) * 100
                    );
                }
            },
        })
        .then((response) => response.data.location)
        .catch((error) => {
            throw new Error(
                `Wysyłanie zakończone niepowodzeniem: ${error.message}`
            );
        });
};

function submitPostRequest() {
    let hadError = ref(false);

    router.post(route("blog-create.post"), postForm, {
        onError: (err) => {
            ResetObject(errors);
            Object.assign(errors, err);
            hadError = true;
        },
        headers: {
            "Content-Type": "multipart/form-data",
        },
        preserveScroll: () => hadError,
    });
    console.log(errors);
}
</script>

<template>
    <section class="pt-50px pb-50px">
        <div class="container">
            <div
                class="d-flex column-gap-10px mb-20px flex-wrap-wrap row-gap-20px"
            >
                <button @click="console.log(postForm)" class="btn btn-white">
                    Loguj zawartość formularza
                </button>
                <button @click="console.log(errors)" class="btn btn-white">
                    Loguj errory
                </button>
                <button @click="ResetObject(errors)" class="btn btn-white">
                    Resetuj errory
                </button>
            </div>

            <form
                class="form"
                @submit.prevent="submitPostRequest"
                enctype="multipart/form-data"
            >
                <div class="input-wrap col-12">
                    <label for="post-title">Nazwa wpisu*</label>
                    <input
                        type="text"
                        placeholder="Nazwa wpisu"
                        required
                        id="post-title"
                        autocomplete="post-title"
                        name="post-title"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                        v-model="postForm.post_name"
                    />
                </div>
                <div class="error-msg" v-if="errors.post_name">
                    {{ errors.post_name }}
                </div>
                <div class="input-wrap col-12">
                    <label for="post-title">Kategoria wpisu*</label>
                    <select required v-model="postForm.post_type" name="post-category" id="">
                        <option selected disabled value="0">Wybierz kategorię</option>
                        <option v-for="category in props.post_types" :key="category.id" :value="category">{{category}}</option>
                    </select>
                </div>
                <div class="error-msg" v-if="errors.post_type">
                    {{ errors.post_type }}
                </div>
                <div class="input-wrap col-12">
                    <label
                        for="event-image"
                        class="d-flex align-items-start flex-column"
                    >
                        <span class="d-flex mb-20px"
                            >Zdjęcie główne wpisu*</span
                        >
                        <div v-if="postForm.post_image">
                            <img :src="postImageUrl" alt="" />
                        </div>
                        <input
                            type="file"
                            id="event-image"
                            name="event-image"
                            accept="image/*"
                            required
                            placeholder="Obrazek główny*"
                            spellcheck="false"
                            value=""
                            aria-required="true"
                            class="d-none"
                            @change="handleFileUpload"
                        />
                        <span
                            style="cursor: pointer"
                            class="btn btn-md d-flex mb-10px"
                            >Wybierz plik</span
                        >
                        <span
                            class="mb-10px fw-bold"
                            v-if="postForm.post_image"
                            >{{ postForm.post_image.name }}</span
                        >
                        <p class="fs-14">
                            Zalecane ratio 4:3, Rozdzielczość min. 800x600,
                            maksymalny rozmiar 10MB
                        </p>
                    </label>
                    <div class="error-msg" v-if="errors.post_image">
                        {{ errors.post_image }}
                    </div>
                </div>
                <div class="error-msg" v-if="errors.post_image">
                    {{ errors.post_image }}
                </div>
                <div class="input-wrap col-12">
                    <label class="mb-15px" for="post-description"
                        >Zawartość wpisu*</label
                    >
                    <Editor
                        api-key="9xfliuzz7ewega4fyhr4ewcymh6ye1gut2xoz8gc9zd140t7"
                        name="event-description"
                        spellcheck="false"
                        id="event-description"
                        placeholder="Opis wpisu"
                        v-model="postForm.post_content"
                        :init="{
                            toolbar_mode: 'sliding',
                            content_style: 'body { font-family: Arial; }',
                            images_upload_handler: HandleEditorImage(),
                            images_upload_credentials: true,
                            forced_root_block: false,
                            toolbar:
                                'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | language',
                            tinycomments_mode: 'embedded',
                            tinycomments_author: 'Author name',
                            relative_urls: false,
                            mergetags_list: [
                                { value: 'First.Name', title: 'First Name' },
                                { value: 'Email', title: 'Email' },
                            ],
                        }"
                    />
                </div>
                <div class="error-msg" v-if="errors.post_content">
                    {{ errors.post_content }}
                </div>
                <div class="input-wrap col-12">
                    <input type="submit" value="Stwórz wpis" />
                </div>
            </form>
        </div>
    </section>
</template>

<style scoped lang="scss"></style>
