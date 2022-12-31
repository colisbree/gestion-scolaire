<template>
    <button class="btn btn-primary"  data-toggle="modal" data-target="#CreateNVModal"><i class="fa fa-plus"></i> Nouveau</button>

    <!-- Modal -->
    <div class="modal fade" 
        id="CreateNVModal" 
        tabindex="-1" 
        role="dialog" 
        aria-labelledby="NiveauScolaireModalLabel"
        aria-hidden="true"
        >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="NiveauScolaireModalLabel">Ajouter un niveau scolaire</h5>
                    <button type="button" v-on:click="closeModal" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form v-on:submit.prevent="soumettre" id="createForm">
                        <div class="form-group">
                            <label for="">Nom</label>
                            <input type="text" required class="form-control" v-model="nomNouveauNS">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" @click="closeModal">Fermer</button>
                    <button form="createForm" type="submit" class="btn btn-success">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

    import { Inertia } from '@inertiajs/inertia'
    import { onMounted, ref } from 'vue'
    import { useSwalSuccess, useSwalError } from '../../Composables/alert'

    //lier la variable au champ input (too with data byding)
    const nomNouveauNS = ref("")
    // fin

    let createModal = ""
    onMounted(()=>{
        createModal = $('#CreateNVModal')
    })

    const closeModal = () => {
        createModal.modal('hide')
        nomNouveauNS.value = ""
    }

    const soumettre = () => {
        const nom = nomNouveauNS.value // récupère la valeur d'une variable passée par Référence
        const url = route('niveauscolaire.store')
        // on peut utiliser axios pour envoyer la valeur dans la BDD,
        // mais voici la façon de faire avec intertia
        Inertia.post(
            url, 
            {nom: nom}, 
            {
                onSuccess: (page) => {
                    closeModal()
                    // afficher un message de succès avec sweetAlert2
                    // depuis le fichier resources/js/composables/alert.js
                    useSwalSuccess("Niveau scolaire ajouté avec succès !")
                },
                onError: (errors) => {
                    // afficher un message d'erreur
                    useSwalError("Une erreur s'est produite.")
                }
        })
    }
</script>