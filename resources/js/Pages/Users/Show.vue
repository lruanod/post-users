<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
const props =defineProps({
    user:Object,
    errors: Object,
});
const form = useForm({
    name: props.user.name,
    password: props.user.password,
    email:props.user.email,
    id:props.user.id,
});
function submit(){
    form.post('/users/update');
}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Update Posts
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="font-sans text-gray-900 antialiased">
                        <div class="pt-4 bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <form class="w-full max-w-sm" @submit.prevent="submit()">
                                    <div class="md:flex md:items-center mb-6">
                                        <div class="md:w-1/3">
                                            <label class="block text-green-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                                                Name
                                            </label>
                                        </div>
                                        <div class="md:w-2/3">
                                            <input v-model="form.name" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full px-4 py-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-full-name">
                                        </div>
                                        <div v-if="errors.name" class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                                            <p class="font-bold">Error</p>
                                            <p>{{ errors.name }}</p>
                                        </div>
                                        <div class="md:w-1/3">
                                            <label class="block text-green-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="password">
                                                Password
                                            </label>
                                        </div>
                                        <div class="md:w-2/3">
                                            <input v-model="form.password" type="password"  class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full px-4 py-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="password">
                                        </div>
                                        <div v-if="errors.password" class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                                            <p class="font-bold">Error</p>
                                            <p>{{ errors.password }}</p>
                                        </div>

                                    </div>

                                    <div class="md:flex md:items-center">
                                        <div class="md:w-1/3"></div>
                                        <div class="md:w-2/3">
                                            <button class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold px-4 py-2 rounded" type="submit">
                                                Update User
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
