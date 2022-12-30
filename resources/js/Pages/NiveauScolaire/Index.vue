<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des Niveaux Scolaires</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                            <div class="card-tools">
                                <PaginationVue 
                                    :links="props.niveauScolaires.links" 
                                    :prev="props.niveauScolaires.prev_page_url"
                                    :next="props.niveauScolaires.next_page_url"
                                />
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Niveau Scolaire</th>
                                        <th style="width: 100px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="niveauScolaire in props.niveauScolaires.data">
                                        <td>{{ niveauScolaire.nom }}</td>
                                        <td>
                                            <div class="d-flex justify-items-center">
                                                <button class="btn btn-info mr-2"><i class="fas fa-pen"></i></button>
                                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import PaginationVue from '../../Shared/Pagination.vue';

    //récup des données transmises par le fichier controller
    const props = defineProps({
        niveauScolaires : {
            type: Object,
            required: true,
        } // et on accède à ce tableau via un v-for
    })
</script>