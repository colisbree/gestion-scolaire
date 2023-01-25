<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bienvenue sur notre application de gestion scolaire</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <h2>Bonjour {{ user.name }}</h2>
        </div>
    </div>
</template>


<script setup>
import { usePage } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';

const user = computed(() => {
    return usePage().props.value.auth.user //on fait un props.value car il s'agit d'un objet
})
</script>