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
                            <div class="card-title">
                                <CreateNiveauScolaire />
                            </div>
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
                                    <tr v-for="niveauScolaire in props.niveauScolaires.data" :key="niveauScolaire">
                                        <td>{{ niveauScolaire.nom }}</td>
                                        <td>
                                            <div class="d-flex justify-items-center">
                                                <button @click="openEditModal(niveauScolaire.id)" class="btn btn-info mr-2"><i class="fas fa-pen"></i></button>
                                                <button @click="deleteConfirmation(niveauScolaire.id)" class="btn btn-danger"><i class="fas fa-trash"></i></button>
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

    <EditNiveauScolaire
        :niveau-scolaire-id = "editingElementId"
        :show="showModal"
        @modal-closed="modalClosed" 
    />
</template>

<script setup>
    import { ref } from 'vue';
    import PaginationVue from '@/Shared/Pagination.vue';
    import CreateNiveauScolaire from './CreateNiveauScolaire.vue';
    import EditNiveauScolaire from './EditNiveauScolaire.vue';
    import { useSwalConfirm, useSwalError, useSwalSuccess } from '@/Composables/alert';
    import { Inertia } from '@inertiajs/inertia';

    //récup des données transmises par le fichier controller
    const props = defineProps({
        niveauScolaires : {
            type: Object,
            required: true,
        } // et on accède à ce tableau via un v-for
    })

    // pour passage props au fichier EditNiveauScolaire.vue
    const editingElementId = ref(0)
    const showModal = ref(false)

    const openEditModal = (id) => {
        editingElementId.value = id
        showModal.value = true
    }

    const modalClosed = () => {
        editingElementId.value = 0
        showModal.value = false
    }

    const deleteNiveauScolaire = (id) => {
        Inertia.delete(route("niveauscolaire.delete", {niveauScolaire: id}), {
            onSuccess: (reponse)=>{
                useSwalSuccess("Niveau scolaire supprimé avec succès !")
            },
            onError: (error)=>{
                useSwalError(error.message ?? "Une erreur a été rencontrée") // si error.message est null alors on affiche 'une erreur a été rencontrée'
            },
        })
    }

    const deleteConfirmation = (id) => {
        const message = "Vous êtes sur le point de supprimer cet élément, voulez-vous continuer ?"
        useSwalConfirm(message, ()=>{
            deleteNiveauScolaire(id)
        })
    }
</script>