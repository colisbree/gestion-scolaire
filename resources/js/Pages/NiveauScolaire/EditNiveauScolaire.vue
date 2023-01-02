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
                    <form id="editForm" action="">
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

    // emit <= Communication de l'enfant vers le parent
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
        axios.get(route("niveauScolaire.edit", {niveauScolaire: props.niveauScolaireId}))
            .then((response)=>{
                console.log("reponse : ", response.data);
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
        $("#editModal").modal("show")
    }

    const closeModal = ()=>{
        $("#editModal").modal("hide")
        emit("modalClosed") // <= Envoi au fichier parent la fermeture du modal qui sera intercepté par la ligne @modal-closed="modalClosed" 
    }

</script>