<script setup>
import useAuth from "@/Utilities/useAuth";
import HeroSmall from "@/Components/sections-new/Hero-small.vue";
import blogBg from "~images/blog-bg.jpg";
import {router} from "@inertiajs/vue3";
import { reactive, watch, computed, ref } from 'vue';
import {Link} from "@inertiajs/vue3";
import Editor from "@tinymce/tinymce-vue";
import axios from "axios";

const props = defineProps({
    halls: {
        type: Array,
        required: true,
    },
    genres: {
        type: Array,
    }
});


const sectionPrices = reactive({});

const initSectionPrices = () => {
    props.halls.forEach(hall => {
        hall.sections?.forEach(section => {
            if (!sectionPrices.hasOwnProperty(section.id)) {
                sectionPrices[section.id] = null;
            }
        });
    });
};

initSectionPrices();

console.log(sectionPrices);

watch(() => props.halls, () => {
    initSectionPrices();
});

const errors = reactive({});
const requestEventForm = reactive({
    event_name: null,
    event_additional_url: null,
    event_date: null,
    event_start: null,
    event_end: null,
    contact_email: null,
    contact_email_additional: null,
    event_description: null,
    event_location: null,
    event_description_additional: null,
    genre: null,
    section_prices: sectionPrices
});

const eventImage = ref(null);

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        eventImage.value = file;
    }
};

function submitEventRequest() {
    let hadError = false;
    errors.clear;

    if (eventImage.value) {
        requestEventForm.event_image = eventImage.value;
    }

    router.post(route("event-create.post"), requestEventForm, {
        preserveScroll: () => hadError,
        onError: (err) => {
            Object.assign(errors, err);
            hadError = true;
        },
        headers: {
            "Content-Type": "multipart/form-data",
        },
    });
    console.log(requestEventForm);
}

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
            <button @click="console.log(requestEventForm)" class="btn btn-white">Loguj zawartość formularza</button>
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
                        Dodatkowy adres URL wydarzenia taki jak link do spotify czy strony wykonawcy/organizatora
                    </p>
                    <input
                        type="text"
                        placeholder="Url wydarzenia"
                        id="event-slug"
                        name="event-slug"
                        spellcheck="false"
                        value=""
                        aria-required="false"
                        v-model="requestEventForm.event_additional_url"
                    />
                </div>
                <div class="error-msg" v-if="errors.event_additional_url">
                    {{ errors.event_additional_url }}
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
                    <div class="error-msg" v-if="errors.event_date">
                        {{ errors.event_date }}
                    </div>
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
                    <div class="error-msg" v-if="errors.event_start">
                        {{ errors.event_start }}
                    </div>
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
                    <div class="error-msg" v-if="errors.event_end">
                        {{ errors.event_end }}
                    </div>
                </div>
                <div class="input-wrap col-12">
                    <label for="event-location"
                    >Lokalizacja / Wybrana sala*</label
                    >
                    <div class="select-wrap mb-30px">
                        <i class="fa fa-chevron-down"></i>
                        <select
                            id="event-location"
                            class="col-12"
                            v-model="requestEventForm.event_location"
                            @change="console.log(requestEventForm.event_location)"
                        >
                            <option disabled :value="null">
                                Wybierz halę
                            </option>
                            <option :value="hall.id" v-for="hall in halls">
                                {{ hall.hall_name }}
                            </option>
                        </select>
                    </div>
                    <div class="error-msg" v-if="errors.event_location">
                        {{ errors.event_location }}
                    </div>
                    <div>
                        <div
                            class="flex-column hall"
                            v-for="hall in halls"
                            :key="hall.id"
                            :title="hall.hall_name"
                            v-show="requestEventForm.event_location === hall.id"
                        >
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center">
                                    <div class="legend legend-stand"></div>
                                    <p>Hale z miejscami stojącymi</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="legend legend-seat"></div>
                                    <p>Hale z miejscami siedzącymi</p>
                                </div>
                            </div>
                            <div
                                class="hall__row"
                                v-for="(row, hrowIndex) in hall.hall_height"
                                :key="hrowIndex"
                            >
                                <div
                                    class="hall__col"
                                    v-for="(col, hcolIndex) in hall.hall_width"
                                    :key="hcolIndex"
                                >
                                    <div
                                        class="petla"
                                        v-for="section in hall.sections.filter(
                            (section) =>
                                section.section_height === hrowIndex + 1 &&
                                section.section_width === hcolIndex + 1
                        )"
                                        :key="section.id"
                                    >
                                        <div
                                            class="hall__section-seat"
                                            v-if="section.section_type === 'seat'"
                                        >
                                            <input type="text" v-number-only inputmode="numeric" maxlength="5" placeholder="Cena za miejsce siedzące" v-model="sectionPrices[section.id]" @input="console.log(requestEventForm)">
                                            <div class="hall__seat-cont">
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>
                                                <div class="hall__seat"></div>

                                            </div>
                                        </div>
                                        <div v-else class="hall__section-stand">
                                            <input type="text" v-number-only inputmode="numeric" maxlength="5" placeholder="Cena za miejsce stojące" v-model="sectionPrices[section.id]">
                                            <div class="hall__seat-cont">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input-wrap col-12">
                    <label for="event-location"
                    >Kategoria*</label
                    >
                    <div class="select-wrap">
                        <i class="fa fa-chevron-down"></i>
                        <select
                            id="event-location"
                            class="col-12"
                            required
                            v-model="requestEventForm.genre"
                            @change="console.log(requestEventForm)"
                        >
                            <option disabled :value="null">
                                Wybierz kategorię
                            </option>
                            <option :key="genre.id" :value="genre.id" v-for="genre in genres">
                                {{ genre.genre_name }}
                            </option>
                        </select>
                        <div class="error-msg" v-if="errors.genre">
                            {{ errors.genre }}
                        </div>
                    </div>

                    <div>
                        Wizualizacje naszych hal znajdziesz
                        <Link :href="`${route('about-us')}#halls`">Tutaj</Link>
                    </div>
                </div>
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
                    <div class="error-msg" v-if="errors.contact_email">
                        {{ errors.contact_email }}
                    </div>
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
                    <div class="error-msg" v-if="errors.contact_email_additional">
                        {{ errors.contact_email_additional }}
                    </div>
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
                    images_upload_credentials: true,
        forced_root_block: false,
                    plugins: [
                        'autolink',
                        'emoticons',
                        'image',
                        'link',
                        'lists',
                        'media',
                        'table',
                        'visualblocks',
                        'wordcount',
                        'mediaembed',
                        'casechange',
                        'a11ychecker',
                        'tinymcespellchecker',
                        'powerpaste',
                        'advtable',
                        'advcode',
                        'tableofcontents',
                        'autocorrect',
                        'typography',
                        'inlinecss',
                        'markdown',
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
                    <div class="error-msg" v-if="errors.event_description">
                        {{ errors.event_description }}
                    </div>
                </div>
                <div class="input-wrap col-12">
                    <label for="event-description">Więcej informacji</label>
                    <textarea
                        id="event-description-additional"
                        name="event-description-additional"
                        placeholder="Więcej informacji"
                        spellcheck="false"
                        aria-required="false"
                        v-model="requestEventForm.event_description_additional"
                    ></textarea>
                    <div class="error-msg" v-if="errors.event_description_additional">
                        {{ errors.event_description_additional }}
                    </div>
                </div>
                <div class="input-wrap col-12">
                    <input type="submit" value="Stwórz wydarzenie"/>
                </div>
            </form>
        </div>
    </section>
</template>
<script>

</script>
