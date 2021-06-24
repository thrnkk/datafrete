<template>
    <div id="removeCEPModal" class="modal fade">

		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">						
					<h4 class="modal-title">Excluir {{origin}} <i class="material-icons align-text-top">&#xe5c8;</i> {{destination}}</h4>
					<button type="button" class="close" data-dismiss="modal" @click="resetForm" aria-hidden="true">&times;</button>
				</div>

				<div class="modal-body">					
					<p> Deseja mesmo excluir estes dados? </p>
					<p class="text-danger"><small>Essa ação não pode ser desfeita.</small></p>
					<transition name="fade" mode="out-in" appear>
						<span style="color: #00C851" :key="message">{{message}} &nbsp;</span>
					</transition>
				</div>

				<div class="modal-footer">
					<input type="button" @click="resetForm" class="btn btn-default" data-dismiss="modal" value="Cancelar">
					<button type="submit" class="btn btn-danger" :disabled="blockButton" @click="submitForm" value="Excluir">Excluir</button>
				</div>

			</div>
		</div>

	</div>
</template>

<script>
export default {
  	props: {selectedCep: Object},
	data() {
		return {
			id: '',
			origin: '',
			destination: '',
			distance: '',
			message: '',
			blockButton: false
		};
	},
	watch: {
		selectedCep: function(cep) {
			if (cep !== null) {

				if(this.id != cep.id) {
					this.id = cep.id
					this.origin = cep.origin
					this.destination = cep.destination
					this.distance = cep.cep_distance
				}

			}
		
		}
	},
	methods: {
		submitForm() {
			axios.delete('ceps/' + this.id)
			.then(response => {
				this.blockButton = true
				this.message = 'Os dados foram excluídos com sucesso!'
				this.$parent.refresh()
			})
			
		},

		resetForm() {
			this.id = ''
			this.origin = ''
			this.destination = ''
			this.distance = ''
			this.message = ''
		}
  	}
};
</script>