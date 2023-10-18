

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Posts
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="font-sans text-gray-900 antialiased">
                        <div class="pt-4 bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                               <form class="w-full max-w-sm" enctype="multipart/form-data" @submit.prevent="submit">
                                   <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">


                                       <div class="mb-4">
                                           <label for="name"  class="text-gray-700 text-sm font-bold mb-2">Titulo</label>
                                           <input id="name" v-model="form.title"   type="text" class="shadow appearance-none rounded  w-full py-2 px-3 text-gray-700 bg-gray-50 leading-tight focus:outline-none focus:shadow-outline" placeholder="Titulo" >
                                           <div v-if="errors.title" class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                                               <p class="font-bold">Error</p>
                                               <p>{{ errors.title }}</p>
                                           </div>
                                       </div>


                                       <div class="mb-4">
                                           <label for="urls"  class="text-gray-700 text-sm font-bold mb-2">File</label>
                                           <file-pond
                                               name="image"
                                               ref="pond"
                                               class-name="my-pond"
                                               label-idle="Suelte los archivos aquí..."
                                               allow-multiple="true"
                                               accepted-file-types="image/jpeg, image/png"
                                               :files="files"
                                               :server="{
                                                        process: '/upload',
                                                        revert: '/revert',
                                                        headers: {
                                                            'X-CSRF-TOKEN': $page.props.csrf_token,
                                                        },
                                                    }"
                                           />
                                           <div v-if="errors.urls" class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                                               <p class="font-bold">Error</p>
                                               <p>{{ errors.urls }}</p>
                                           </div>


                                       </div>

                                       <div class="mb-4 flex w-full justify-center items-center">
                                           <button class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold px-4 py-2 rounded" type="submit">
                                               Create post
                                           </button>
                                       </div>
                                   </div>


                               </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import {Head, Link, useForm, router,usePage } from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import vueFilePond from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";

import Swal from 'sweetalert2';


// Import styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import { computed } from "vue";
const props =defineProps({
    errors: Object,
    successMessage:null})
// Create FilePond component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);
const page = usePage();
const pond = ref(null);
let files = ref([]);
const csrf = computed(() => page.props.csrf_token);

const form = useForm({
    title: ""
});

async function submit() {
   await form.post('/posts',{
        onSuccess: () => {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: props.successMessage,
            })

            files=null;
            form.reset()
        }
    });





}


</script>

