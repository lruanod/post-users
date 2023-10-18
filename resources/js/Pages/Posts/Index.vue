<script setup>
import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Swal from 'sweetalert2';
import Pagination from "@/Components/Paginator.vue";

defineProps({
    posts:Object,
    Busqueda:'',
});
const form = useForm({
    id:''
});

const page = usePage();
const form2 = useForm({
    Busqueda: page.props.Busqueda
})
function  showImage() {
    return "/storage/";
}

function buscarEnModelo() {

    form2.get('/posts', {
        preserveScroll: true,
        preserveState: true
    });
}



const deletePost = (id,title) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true
    });
    alerta.fire({
        title:'Are you sure delete '+title+' ?',
        icon:'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Yes,delete',
        cancelButtonText:'<i class="fa-solid fa-ban"></i> Cancel'
    }).then((result) => {
        if(result.isConfirmed) {
          //  form.delete(route('departments.destroy',id));
            form.get('/posts/'+id+'/delete')

        }
    });
}

const deleteImg = (id) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true
    });
    alerta.fire({
        title:'Are you sure delete ?',
        icon:'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Yes,delete',
        cancelButtonText:'<i class="fa-solid fa-ban"></i> Cancel'
    }).then((result) => {
        if(result.isConfirmed) {
            //  form.delete(route('departments.destroy',id));
            form.get('/images/'+id+'/delete')

        }
    });
}
</script>
<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Posts
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="font-sans text-gray-900 antialiased">
                        <div class="pt-4 bg-gray-200  shadow-xl sm:rounded-lg">
                            <div class="min-h-screen flex flex-col items-start pt-6 sm:pt-0 bg-gray-200">
                                <Link href="/posts/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Post</link>
                                <form @submit.prevent="buscarEnModelo">
                                    <input type="text" v-model="form2.Busqueda"/>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buscar</button>
                                </form>
                                <table class="table-fixed w-full">
                                    <thead>
                                    <tr>
                                        <th class="w-auto px-4 py-2">Id</th>
                                        <th class="w-auto px-4 py-2">Title</th>
                                        <th class="w-1/4 px-4 py-2">Images</th>
                                        <th class="w-auto">Action</th>

                                    </tr>
                                    </thead>
                                    <tbody class="border border-gray-400 border-4  bg-gray-100">
                                    <tr v-for="post in posts.data" :key="post.id" class="hover:bg-blue-100">
                                        <td class="border border-gray-400 border-1">{{post.id}}</td>
                                        <td class="border border-gray-400 border-1">{{post.title}}</td>
                                        <td class="border border-gray-400 border-1">
                                            <span v-for="imagen in post.imagens" :key="imagen.id">
                                                  <img :src="showImage()+imagen.carpeta+'/'+imagen.url" class="object-cover h-auto w-auto mb-2 mt-2">
                                                    <button class="bg-red-500 hover:bg-blue-400 text-white font-bold py-2 px-6 rounded-full" @click="deleteImg(imagen.id)">Eliminar</button>
                                            </span>
                                        </td>
                                        <td class="border border-gray-400 border-1">
                                            <div class="grid xl:grid-cols-2 md:grid-cols-1 gap-2 flex flex-col items-center">
                                                <div class="mb-2">
                                                    <Link :href="'/posts/'+post.id+'/edit'" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2.5 px-6 rounded-full">Editar</link>
                                                </div>
                                                <div class="mb-2">
                                                    <button class="bg-red-500 hover:bg-blue-400 text-white font-bold py-2 px-6 rounded-full" @click="deletePost(post.id,post.title)">Eliminar</button>
                                                </div>
                                            </div>

                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <Pagination :data="posts" />
            </div>

        </div>
    </AppLayout>
</template>

