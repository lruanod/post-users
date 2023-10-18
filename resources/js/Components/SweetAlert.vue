<template>
    <div></div>
</template>

<script>
import Swal from 'sweetalert2';

export default {
    methods: {
        success(message) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: message,
            });
        },

        error(message) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
            });
        },

        // Otros métodos para tipos de alertas adicionales (advertencia, información, etc.).
    },
};
</script>
