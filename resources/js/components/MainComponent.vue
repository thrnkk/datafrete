<template>
  <!-- Container Tabela -->
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">

                    <div class="col-sm-3 logo-wrapper">
                        <img src="logo-full.png"/>
                    </div>
                    <div class="col-sm-9">
                        <a href="#addCEPModal" class="btn btn-out-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Adicionar Nova Distância</span></a>
                        <a href="#refreshedModal" @click="refresh()" class="btn btn-out-info" data-toggle="modal"><i class="material-icons">&#xE5D5;</i> <span>Atualizar Informações</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="red-color"><b><i class="material-icons">&#xe873;</i><span class="align-text-top"> ID </span></b></th>
                        <th class="red-color"><b><i class="material-icons">&#xe905;</i><span class="align-text-top"> Origem </span></b></th>
                        <th class="red-color"><b><i class="material-icons">&#xe904;</i><span class="align-text-top"> Destino </span></b></th>
                        <th class="red-color"><b><i class="material-icons">&#xe9e4;</i><span class="align-text-top"> Distância </span></b></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="cep in this.CEPs" :key="cep.id">
                        <td> {{cep.id}} </td>
                        <td> {{cep.origin}} </td>
                        <td> {{cep.destination}} </td>
                        <td> {{cep.distance}} Km</td>
                        <td>
                            <a href="#editCEPModal" @click="selectCEP(cep)" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Editar">&#xE150;</i></a>
                            <a href="#removeCEPModal" @click="selectCEP(cep)" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Excluir">&#xE872;</i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <addCEPModal></addCEPModal>
        <editCEPModal :selected-cep="selectedCEP"></editCEPModal>
        <removeCEPModal :selected-cep="selectedCEP"></removeCEPModal>
        <refreshModal></refreshModal>

    </div>
</template>

<script>

import addCEPModal from "./AddCEPModal";
import editCEPModal from "./EditCEPModal";
import removeCEPModal from "./RemoveCEPModal";
import refreshModal from "./RefreshModal";

export default {
    data() {
        return {
            CEPs: [],
            selectedCEP: null,
            selectedCEPsIds: []

        }
    },

    components: {addCEPModal, removeCEPModal, editCEPModal, refreshModal},

    mounted() {

        this.refresh()

    },

    methods: {

        refresh() {
            axios.get('ceps/').then(response => {
                this.CEPs = response.data
                this.selectedCEP  = null
                this.selectedCEPsIds  = []
            })
        },

        selectCEP(cep) {
            this.selectedCEP = cep
        }

    }
}
</script>
