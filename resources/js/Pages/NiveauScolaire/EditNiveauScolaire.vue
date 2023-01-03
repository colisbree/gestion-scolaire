<template>
    
    <!-- Modal -->
    <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edition du niveau scolaire "{{ editNiveauScolaire.nom }}"</h5>
                    <button type="button" class="close" @click="closeModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" @submit.prevent="soumettre">
                        <div class="form-group">
                            <label for="">Nom</label>
                            <input 
                                type="text" 
                                required 
                                class="form-control" 
                                :class="{'is-invalid': editNiveauScolaire.nomError != ''}" 
                                v-model="editNiveauScolaire.nom"
                            >
                            <span v-if="editNiveauScolaire.nomError != '' " class="invalid-feedback error">{{ editNiveauScolaire.nomError }}</span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="closeModal">Fermer</button>
                    <button form="editForm" type="submit" class="btn btn-success">Soumettre</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { reactive, watch } from "vue";
    import { useSwalSuccess, useSwalError} from "@/Composables/alert";
    import { Inertia } from "@inertiajs/inertia";

    // defineEmits <= Communication de l'enfant vers le parent
    const emit = defineEmits(["modalClosed"])

    const props = defineProps({
        niveauScolaireId:{
            type: Number,
            required: true
        },
        show:{
            type: Boolean,
            default: false
        }
    })

    const editNiveauScolaire = reactive({
        id: "",
        nom: "",
        nomError: ""
    })

    const getNiveauScolaireById = () => {
        axios.get(route("niveauscolaire.edit", {niveauScolaire: props.niveauScolaireId}))
            .then((response)=>{
                editNiveauScolaire.id = response.data.niveauScolaire.id
                editNiveauScolaire.nom = response.data.niveauScolaire.nom
            })
            .catch((error)=>{
                console.log(error);
            })
    }

    //watcher => fonction qui écoute et exécute un callback quand la valeur de la propriété écoutée est modifiée
    watch(
        ()=>props.show, // écoute le changement de la propriété show
        (newVal, oldVal)=>{
            if(newVal){
                openModal()
            }else{
                closeModal()
            }
        }
    )

    const openModal = ()=>{
        getNiveauScolaireById()
        $("#editModal").modal("show")
    }

    const closeModal = ()=>{
        $("#editModal").modal("hide")
        emit("modalClosed") // <= informe le parent de la fermeture du modal qui sera intercepté par la ligne @modal-closed="modalClosed" dans le fichier parent
    }

    const soumettre = () => {
        Inertia.put(
            route("niveauscolaire.update", {niveauScolaire: props.niveauScolaireId}), 
            {nom: editNiveauScolaire.nom},
            {
                onSuccess: (reponse)=>{
                    useSwalSuccess("Niveau scolaire mis à jour avec succès !")
                    closeModal()
                },
                onError: (error)=>{
                    useSwalError("Une erreur a été rencontrée")
                    editNiveauScolaire.nomError = error.nom
                },
            }
        )
    }

</script>