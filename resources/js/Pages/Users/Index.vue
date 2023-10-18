<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link, router, useForm, usePage} from "@inertiajs/vue3";
import Pagination from "@/Components/Paginator.vue";
import Swal from "sweetalert2";
//import {reactive, } from "vue";
defineProps({
    users:Object,
    Busqueda:'',
});

const page = usePage();
const form = useForm({
    Busqueda: page.props.Busqueda
})

function buscarEnModelo() {

    form.get('/users', {
        preserveScroll: true,
        preserveState: true
    });
}

const deleteUser = (id) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true
    });
    alerta.fire({
        title:'Are you sure delete  ?',
        icon:'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Yes,delete',
        cancelButtonText:'<i class="fa-solid fa-ban"></i> Cancel'
    }).then((result) => {
        if(result.isConfirmed) {
            //  form.delete(route('departments.destroy',id));
            form.get('/users/'+id+'/delete')

        }
    });
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="font-sans text-gray-900 antialiased">
                        <div class="pt-4 bg-gray-200  shadow-xl sm:rounded-lg">
                            <div class="min-h-screen flex flex-col items-start pt-6 sm:pt-0 bg-gray-200">
                                <Link href="/users/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create User</link>
                                <form @submit.prevent="buscarEnModelo">
                                    <input type="text" v-model="form.Busqueda"/>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buscar</button>
                                </form>
                                <table class="table-fixed w-full">
                                    <thead>
                                    <tr>
                                        <th class="w-auto px-4 py-2">Id</th>
                                        <th class="w-auto px-4 py-2">Nombre</th>
                                        <th class="w-auto px-4 py-2">Email</th>
                                        <th class="w-auto">Acciones</th>

                                    </tr>
                                    </thead>

                                    <tbody class="border border-gray-400 border-4  bg-gray-100">
                                    <tr v-for="user in users.data" :key="user.id" class="hover:bg-blue-100">
                                        <td class="border border-gray-400 border-1">{{user.id}}</td>
                                        <td class="border border-gray-400 border-1">{{user.name}}</td>
                                        <td class="border border-gray-400 border-1">{{user.email}}</td>
                                        <td class="border border-gray-400 border-1">

                                            <div class="grid xl:grid-cols-2 md:grid-cols-1 gap-2 flex flex-col items-center">
                                                <div class="mb-2">
                                                    <Link :href="'/users/'+user.id+'/edit'" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2.5 px-6 rounded-full">Editar</link>
                                                </div>
                                                <div class="mb-2">
                                                    <button class="bg-red-500 hover:bg-blue-400 text-white font-bold py-2 px-6 rounded-full" @click="deleteUser(user.id)">Eliminar</button>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <Pagination :data="users" />

                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>

</script>

