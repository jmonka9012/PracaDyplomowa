<script setup>
import useAuth from "@/Utilities/useAuth";
import ResetObject from "@/Utilities/resetObject";
import IsNotEmpty from "@/Utilities/isNotEmpty";
import IsNotEmptyPrefix from "@/Utilities/isNotEmpty";

import HeroSmall from "@/Components/sections-new/Hero-small.vue";
import DropDown from "@/Components/partials/DropDown.vue";
import { Link } from "@inertiajs/vue3";
import blogBg from "~images/blog-bg.jpg";
import Editor from "@tinymce/tinymce-vue";

import { router } from "@inertiajs/vue3";
import { reactive, watch, computed, ref } from "vue";

import axios from "axios";

const props = defineProps({
    halls: {
        type: Array,
        required: true,
    },
    genres: {
        type: Array,
    },
});
console.log(props);

const sectionPrices = reactive({});

const initSectionPrices = () => {
    props.halls.forEach((hall) => {
        if (!sectionPrices[hall.id]) {
            sectionPrices[hall.id] = {};
        }
        hall.sections?.forEach((section) => {
            if (!sectionPrices[hall.id].hasOwnProperty(section.id)) {
                sectionPrices[hall.id][section.id] = null;
            }
        });
    });
};

initSectionPrices();

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
    event_image: null,
    event_description_additional: null,
    genre: null,
});

//const eventImageUrl = ref(null);
const eventImageUrl = computed(() => {
    const file = requestEventForm.event_image;
    return file ? URL.createObjectURL(file) : null;
});

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    delete errors.event_image;

    if (file && file.size <= 10000000 && file.type.startsWith("image")) {
        const img = new Image();
        const objectUrl = URL.createObjectURL(file);

        img.onload = () => {
            if (img.width >= 800 && img.height >= 600) {
                requestEventForm.event_image = file;
            } else {
                errors.event_image = "Obrazek jest za mały";
            }
            URL.revokeObjectURL(objectUrl);
        };

        img.src = objectUrl;
    } else if (file.size > 10000000) {
        errors.event_image = "Obrazek jest za duży";
    } else if (!file.type.startsWith("image")) {
        errors.event_image = "Plik nie jest obrazem";
    }
};

function submitEventRequest() {
    let hadError = ref(false);

    if (sectionPrices && requestEventForm.event_location) {
        requestEventForm.section_prices =
            sectionPrices[requestEventForm.event_location];
    }

    router.post(route("event-create.post"), requestEventForm, {
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
    console.log(requestEventForm);
    console.log(errors);
}

const HandleEditorImage = () => (blobInfo, progress) => {
    const formData = new FormData();
    formData.append("image", blobInfo.blob(), blobInfo.filename());

    return axios
        .post(route("event-create.image"), formData, {
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
            throw new Error(`Wysyłanie zakończone niepowodzeniem: ${error.message}`);
        });
};

function debugLogForm() {
    let logReactive = requestEventForm;

    if (sectionPrices && requestEventForm.event_location) {
        logReactive.section_prices =
            sectionPrices[requestEventForm.event_location];
    }
    console.log(logReactive);
}

const { user, isLoggedIn } = useAuth();
</script>

<template>
    <HeroSmall title="Zorganizuj wydarzenie" :source="blogBg"></HeroSmall>
    <section class="pt-50px pb-50px">
        <div class="container">
            <button @click="debugLogForm" class="btn btn-white">
                Loguj zawartość formularza
            </button>
            <button @click="console.log(errors)" class="btn btn-white">
                Loguj errory
            </button>
            <button @click="ResetObject(errors)" class="btn btn-white">
                Resetuj errory
            </button>
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
                        Dodatkowy adres URL wydarzenia taki jak link do spotify
                        czy strony wykonawcy/organizatora
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
                    <label
                        for="event-image"
                        class="d-flex align-items-start flex-column"
                    >
                        <span class="d-flex mb-20px"
                            >Obrazek główny Wydarzenia*</span
                        >
                        <div v-if="requestEventForm.event_image">
                            <img :src="eventImageUrl" alt="" />
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
                            v-if="requestEventForm.event_image"
                            >{{ requestEventForm.event_image.name }}</span
                        >
                        <p class="fs-14">
                            Zalecane ratio 4:3, Rozdzielczość min. 800x600,
                            maksymalny rozmiar 10MB
                        </p>
                    </label>
                    <div class="error-msg" v-if="errors.event_image">
                        {{ errors.event_image }}
                    </div>
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
                            @change="
                                console.log(requestEventForm.event_location)
                            "
                        >
                            <option disabled :value="null">Wybierz halę</option>
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
                                                section.section_height ===
                                                    hrowIndex + 1 &&
                                                section.section_width ===
                                                    hcolIndex + 1
                                        )"
                                        :key="section.id"
                                    >
                                        <div
                                            class="hall__section-seat"
                                            v-if="
                                                section.section_type === 'seat'
                                            "
                                        >
                                            <input
                                                type="text"
                                                v-number-only
                                                inputmode="numeric"
                                                placeholder="Cena za miejsce siedzące"
                                                v-model="
                                                    sectionPrices[hall.id][
                                                        section.id
                                                    ]
                                                "
                                            />
                                            <div class="hall__seat-cont">
                                                <div
                                                    class="hall__section-row"
                                                    v-for="(
                                                        row, rowIndex
                                                    ) in section.row"
                                                    :key="rowIndex"
                                                >
                                                    <div
                                                        class="hall__seat"
                                                        v-for="(
                                                            col, colIndex
                                                        ) in section.col"
                                                        :key="colIndex"
                                                    ></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="hall__section-stand">
                                            <input
                                                type="text"
                                                v-number-only
                                                inputmode="numeric"
                                                placeholder="Cena za miejsce stojące"
                                                v-model="
                                                    sectionPrices[hall.id][
                                                        section.id
                                                    ]
                                                "
                                            />
                                            <div class="hall__seat-cont"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="error-msg mb-20px"
                            v-if="IsNotEmptyPrefix(errors, 'section_prices')"
                        >
                            Proszę uzupełnić ceny sekcji
                        </div>
                        <div>
                            Wizualizacje naszych hal znajdziesz
                            <Link
                                class="text-primary"
                                :href="`${route('about-us')}#halls`"
                                >Tutaj</Link
                            >
                        </div>
                    </div>
                </div>
                <div class="input-wrap col-12">
                    <label for="event-location">Kategoria*</label>
                    <!-- <div class="select-wrap">
                        <i class="fa fa-chevron-down"></i>
                        <select
                            multiple
                            id="event-location"
                            class="col-12"
                            required
                            v-model="requestEventForm.genre"
                            @change="console.log(requestEventForm)"
                        >
                            <option disabled :value="null">
                                Wybierz kategorię
                            </option>
                            <option
                                :key="genre.id"
                                :value="genre.id"
                                v-for="genre in genres"
                            >
                                {{ genre.genre_name }}
                            </option>
                        </select>
                        <div class="error-msg" v-if="errors.genre">
                            {{ errors.genre }}
                        </div>
                    </div> -->
                    <DropDown
                        class="dropdown-form"
                        title="Wybierz kategorie"
                        subtitle=""
                    >
                        <select
                            multiple
                            id="event-location"
                            class="col-12"
                            required
                            v-model="requestEventForm.genre"
                            @change="console.log(requestEventForm)"
                        >
                            <option
                                :key="genre.id"
                                :value="genre.id"
                                v-for="genre in genres"
                            >
                                {{ genre.genre_name }}
                            </option>
                        </select>
                    </DropDown>
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
                    <div
                        class="error-msg"
                        v-if="errors.contact_email_additional"
                    >
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
                                // 'autolink',
                                // 'emoticons',
                                // 'image',
                                // 'link',
                                // 'lists',
                                // 'media',
                                // 'table',
                                // 'visualblocks',
                                // 'wordcount',
                                // 'mediaembed',
                                // 'casechange',
                                // 'a11ychecker',
                                // 'tinymcespellchecker',
                                // 'powerpaste',
                                // 'advtable',
                                // 'advcode',
                                // 'tableofcontents',
                                // 'autocorrect',
                                // 'typography',
                                // 'inlinecss',
                                // 'markdown',
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
                    <label class="ff-krona mb-10px" for="event-description"
                        >Więcej informacji</label
                    >
                    <textarea
                        id="event-description-additional"
                        name="event-description-additional"
                        spellcheck="false"
                        aria-required="false"
                        placeholder="Wiadomość"
                        v-model="requestEventForm.event_description_additional"
                    ></textarea>
                    <div
                        class="error-msg"
                        v-if="errors.event_description_additional"
                    >
                        {{ errors.event_description_additional }}
                    </div>
                </div>
                <div class="input-wrap col-12 mb-20px">
                    <input type="submit" value="Stwórz wydarzenie" />
                </div>
                <div class="error-msg" v-if="IsNotEmpty(errors)">
                    Nieprawidłowe dane formularza
                </div>
            </form>
        </div>
    </section>
</template>
<script></script>
