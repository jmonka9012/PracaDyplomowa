<script setup>
import useAuth from "@/Utilities/useAuth";
import HeroSmall from "@/Components/sections-new/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";
import {reactive, ref} from "vue";
import {router} from "@inertiajs/vue3";
import {Link} from "@inertiajs/vue3";
import Wysiwyg from "../Components/sections-new/Wysiwyg.vue";
import Editor from "@tinymce/tinymce-vue";
import axios from "axios";

const errors = reactive({});
// Przechowywanie danych formularza
const requestEventForm = reactive({
    event_name: null,
    event_additional_url: null,
    event_date: null,
    event_start: null,
    event_end: null,
    contact_email: null,
    contact_email_additional: null,
    event_description: '',
    event_description_additional: null,
    event_location: null,
    category: null,
});

const eventImage = ref(null);

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        eventImage.value = file;
    }
};

function submitEventRequest() {
    const formData = new FormData();
    let hadError = false;

    // Dodajemy dane formularza do FormData
    Object.entries(requestEventForm).forEach(([key, value]) => {
        if (value) {
            formData.append(key, value);
        }
    });

    if (eventImage.value) {
        formData.append("event_image", eventImage.value);
    }

    router.post(route("event-create.post"), formData, {
        preserveScroll: () => hadError,
        onError: (err) => {
            Object.assign(errors, err);
            hadError = true;
        },
        headers: {
            "Content-Type": "multipart/form-data",
        },
    });
}

const props = defineProps({
    halls: {
        type: Array,
        required: true,
    },
});

const HandleEditorImage = () => (blobInfo, progress) => {
    const formData = new FormData();
    formData.append('image', blobInfo.blob(), blobInfo.filename());

    return axios.post(route('event-create.image'), formData, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'multipart/form-data',
        },
        onUploadProgress: (progressEvent) => {
            if (progressEvent.lengthComputable) {
                progress((progressEvent.loaded / progressEvent.total) * 100);
            }
        },
    })
        .then(response => response.data.location)
        .catch(error => {
            throw new Error(`Upload failed: ${error.message}`);
        });
};

const {user, isLoggedIn} = useAuth();
</script>

<template>
    <HeroSmall title="Zorganizuj wydarzenie" :source="blogBg"></HeroSmall>
    <section class="pt-50px pb-50px">
        <div class="container">
            <form
                class="form"
                enctype="multipart/form-data"
                @submit.prevent="submitEventRequest"
            >
                <div class="input-wrap col-12">
                    <label for="event-title">Nazwa Wydarzenia*</label>
                    <input
                        type="text"
                        placeholder="Nazwa wydarzenia"
                        required
                        id="event-title"
                        autocomplete="event-title"
                        name="event-title"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                        v-model="requestEventForm.event_name"
                    />
                    <div class="error-msg" v-if="errors.event_name">
                        {{ errors.event_name }}
                    </div>
                </div>
                <div class="input-wrap col-12">
                    <label for="event-slug">Url wydarzenia</label>
                    <p class="mb-10px fs-14">
                        Jeżeli zostawisz pole puste, URL zostanie ustawiony na
                        podstawie podanego tytułu
                    </p>
                    <input
                        type="text"
                        placeholder="Url wydarzenia"
                        id="event-slug"
                        pattern="[a-z0-9-]+"
                        name="event-slug"
                        spellcheck="false"
                        value=""
                        aria-required="false"
                        v-model="requestEventForm.event_url"
                    />
                </div>
                <div class="input-wrap col-12">
                    <label for="event-image">Obrazek główny Wydarzenia*</label>
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
                        @change="handleFileUpload"
                    />
                    <p class="mt-10px fs-14">
                        Zalecane ratio 3:2, zalecana rozdzielczość 1024x1024
                    </p>
                </div>
                <div class="input-wrap col-12">
                    <label for="event-date">Data Wydarzenia*</label>
                    <input
                        type="date"
                        id="event-date"
                        name="event-date"
                        required
                        placeholder="Data Wydarzenia*"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                        v-model="requestEventForm.event_date"
                    />
                </div>

                <div class="input-wrap col-12 col-lg-6">
                    <label for="event-start">Początek Wydarzenia*</label>
                    <input
                        type="time"
                        id="event-start"
                        name="event-start"
                        required
                        placeholder="Rozpoczęcie wydarzenia*"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                        v-model="requestEventForm.event_start"
                    />
                </div>
                <div class="input-wrap col-12 col-lg-6">
                    <label for="event-end">Koniec Wydarzenia*</label>
                    <input
                        type="time"
                        id="event-end"
                        name="event-end"
                        required
                        placeholder="Zakończenie wydarzenia*"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                        v-model="requestEventForm.event_end"
                    />
                </div>
                <div class="input-wrap col-12">
                    <label for="event-location"
                    >Lokalizacja / Wybrana sala*</label
                    >
                    <div class="select-wrap">
                        <i class="fa fa-chevron-down"></i>
                        <select
                            id="event-location"
                            class="col-12"
                            v-model="requestEventForm.event_location"
                        >
                            <option disabled :value="null">
                                Wybierz halę
                            </option>
                            <option :value="hall.id" v-for="hall in halls">
                                {{ hall.hall_name }}
                            </option>
                        </select>
                    </div>

                    <div>
                        Wizualizacje naszych hal znajdziesz
                        <Link :href="`${route('about-us')}#halls`">Tutaj</Link>
                    </div>
                </div>
<!--                <div class="input-wrap col-12">
                    <label for="event-location"
                    >Kategoria</label
                    >
                    <div class="select-wrap">
                        <i class="fa fa-chevron-down"></i>
                        <select
                            id="event-location"
                            class="col-12"
                            v-model="requestEventForm.category"
                        >
                            <option disabled :value="null">
                                Wybierz halę
                            </option>
                            <option :value="hall.id" v-for="hall in halls">
                                {{ hall.hall_name }}
                            </option>
                        </select>
                    </div>

                    <div>
                        Wizualizacje naszych hal znajdziesz
                        <Link :href="`${route('about-us')}#halls`">Tutaj</Link>
                    </div>
                </div>-->
                <div class="input-wrap col-12">
                    <label for="event-email">Email kontaktowy*</label>
                    <input
                        type="email"
                        id="event-email"
                        name="event-email"
                        required
                        placeholder="Email główny"
                        spellcheck="false"
                        value=""
                        aria-required="true"
                        v-model="requestEventForm.contact_email"
                    />
                </div>
                <div class="input-wrap col-12">
                    <label for="event-email-additional">Email dodatkowy</label>
                    <input
                        type="email"
                        id="event-email-additional"
                        name="event-email-additional"
                        placeholder="Email dodatkowy"
                        spellcheck="false"
                        value=""
                        aria-required="false"
                        v-model="requestEventForm.contact_email_additional"
                    />
                </div>
                <div class="input-wrap col-12">
                    <label for="event-description">Opis*</label>
                    <Editor
                        api-key="9xfliuzz7ewega4fyhr4ewcymh6ye1gut2xoz8gc9zd140t7"
                        name="event-description"
                        spellcheck="false"
                        id="event-description"
                        placeholder="Opis wydarzenia"
                        v-model="requestEventForm.event_description"
                        :init="{
                    toolbar_mode: 'sliding',
                    content_style: 'body { font-family: Arial; }',
                    images_upload_handler: HandleEditorImage(),
                    images_upload_credentials: true, // Dodaj to!
        forced_root_block: false,
                    plugins: [
                        'anchor',
                        'autolink',
                        'charmap',
                        'codesample',
                        'emoticons',
                        'image',
                        'link',
                        'lists',
                        'media',
                        'searchreplace',
                        'table',
                        'visualblocks',
                        'wordcount',
                        'checklist',
                        'mediaembed',
                        'casechange',
                        'formatpainter',
                        'pageembed',
                        'a11ychecker',
                        'tinymcespellchecker',
                        'permanentpen',
                        'powerpaste',
                        'advtable',
                        'advcode',
                        'editimage',
                        'advtemplate',
                        'mentions',
                        'tinycomments',
                        'tableofcontents',
                        'footnotes',
                        'mergetags',
                        'autocorrect',
                        'typography',
                        'inlinecss',
                        'markdown',
                        'importword',
                        'exportword',
                        'exportpdf',
                    ],
                    toolbar:
                        'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | language',
                    tinycomments_mode: 'embedded',
                    tinycomments_author: 'Author name',
                    mergetags_list: [
                        { value: 'First.Name', title: 'First Name' },
                        { value: 'Email', title: 'Email' },
                    ],
                }"
                    />
                </div>
                <div class="input-wrap col-12">
                    <label for="event-description">Więcej informacji</label>
                    <textarea
                        id="event-description-additional"
                        name="event-description-additional"
                        placeholder="Więcej informacji"
                        spellcheck="false"
                        required
                        value=""
                        aria-required="false"
                        v-model="requestEventForm.event_description_additional"
                    ></textarea>
                </div>
                <div class="input-wrap col-12">
                    <input type="submit" value="Stwórz wydarzenie"/>
                </div>
            </form>
        </div>
    </section>
</template>
<script>
export default {
    props: {
        csrf_token: String,
    },
};
</script>
