<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link, router} from "@inertiajs/vue3";
import { useForm } from '@inertiajs/vue3'

defineProps({ errors: Object })

const form = useForm({
    name: '',
    email: '',
    password: '',
})


function submit() {
    form.post('/users')

    form.reset()
}



</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-3 lg:px-4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form class="w-full " @submit.prevent="submit">
                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">


                            <div class="mb-4">
                                <label for="name"  class="text-gray-700 text-sm font-bold mb-2">Nombre</label>
                                <input id="name" v-model="form.name"  type="text" class="shadow appearance-none rounded  w-full py-2 px-3 text-gray-700 bg-gray-50 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nombre" >
                                <div v-if="errors.name" class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                                    <p class="font-bold">Error</p>
                                    <p>{{ errors.name }}</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="email"  class="text-gray-700 text-sm font-bold mb-2">Email</label>
                                <input id="email" v-model="form.email"  type="email" class="shadow appearance-none rounded  w-full py-2 px-3 text-gray-700 bg-gray-50 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nombre" >
                                <div v-if="errors.email" class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                                    <p class="font-bold">Error</p>
                                    <p>{{ errors.email }}</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password"  class="text-gray-700 text-sm font-bold mb-2">Password</label>
                                <input id="pasword" v-model="form.password"  type="password" class="shadow appearance-none rounded  w-full py-2 px-3 text-gray-700 bg-gray-50 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nombre" >
                                <div v-if="errors.password" class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                                    <p class="font-bold">Error</p>
                                    <p>{{ errors.password }}</p>
                                </div>
                            </div>


                            <div class="mb-4 flex w-full justify-center items-center">
                                <button class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold px-4 py-2 rounded" type="submit">
                                    Create User
                                </button>
                            </div>


                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AppLayout>
</template>


