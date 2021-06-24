<template>
    <div id="editCEPModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form @submit.prevent="submitForm">		
					<div class="modal-header">

						<transition name="fade" mode="out-in" appear>
							<h4 class="modal-title" :key="changeTitle" >Editar {{originTitle}} <i class="material-icons align-text-top">&#xe5c8;</i> {{destinationTitle}}</h4>
						</transition>		
						
						<button type="button" class="close" data-dismiss="modal" @click="resetForm" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">	
						<div class="form-group">

							<label>Origem</label> 
							<transition name="fade" mode="out-in" appear>
								<label class="red-color font-weight-bold" :key="city_origin">{{city_origin}}</label>
							</transition>

							<input @blur="handleBlur(origin, 'origin')" id="origin" type="text" maxlength="8" class="form-control" v-model="origin" required autocomplete="off">
							<br>

							<label>Latitude: </label>
							<transition name="fade" mode="out-in" appear>
								<span class="red-color font-weight-bold" :key="lat_origin"> {{lat_origin}} </span>
							</transition>

							<br>
							<label>Longitude: </label>
							<transition name="fade" mode="out-in" appear>
								<span class="red-color font-weight-bold" :key="lon_origin"> {{lon_origin}} </span>
							</transition>
						</div>

						<div class="form-group">
							<div class="lightgray-line-100"></div>
						</div>

						<div class="form-group">

							<label>Destino</label>
							<transition name="fade" mode="out-in" appear>
								<label class="red-color font-weight-bold" :key="city_destination">{{city_destination}}</label>
							</transition>

							<input @blur="handleBlur(destination, 'destination')" id="destination" type="text" maxlength="8" class="form-control" v-model="destination" required autocomplete="off">
							<br>

							<label>Latitude: </label>
							<transition name="fade" mode="out-in" appear>
								<span class="red-color font-weight-bold" :key="lat_destination"> {{lat_destination}} </span>
							</transition>

							<br>
							<label>Longitude: </label>
							<transition name="fade" mode="out-in" appear>
								<span class="red-color font-weight-bold" :key="lon_destination"> {{lon_destination}} </span>
							</transition>
						</div>
						<div class="form-group">
							<label>Distância</label>
							<br>
							<transition name="fade" mode="out-in" appear>
								<label class="red-color font-weight-bold h5" :key="distance"> {{distance}} &nbsp;</label>
							</transition>
						</div>

						<transition name="fade" mode="out-in" appear>
							<span style="color: #00C851" :key="message">{{message}} &nbsp;</span>
						</transition>
						

					</div>
					<div class="modal-footer">
                        <input type="button" @click="resetForm" class="btn btn-default" data-dismiss="modal" value="Cancelar">

						<button type="submit" value="submit" class="btn btn-success" :disabled="!city_origin || !city_destination" >Salvar edições</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {selectedCep: Object},
	data() {
		return {

			originTitle: '',
			destinationTitle: '',

			origin: '',
			destination: '',
			distance: '',
			message: '',

			city_origin: '',
			lat_origin: '',
			lon_origin: '',
			city_destination: '',
			lat_destination: '',
			lon_destination: '',

			changeTitle: false
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

					this.originTitle = cep.origin
					this.destinationTitle = cep.destination

					this.handleBlur(cep.origin, 'origin')
					setTimeout(() => this.handleBlur(cep.destination, 'destination'), 2000)
					
				}

			}
		
		}
	},

	methods: {

		handleBlur(cep, field) {

			if (cep){
				axios.get('api/cep/' + cep
				).then(response => {
					if (field == 'origin') {

						// Erro
						if (!Object.keys(response.data).length) {
							this.city_origin = ''
							this.lat_origin = ''
							this.lon_origin = ''

						} else {
							this.city_origin = response.data.cidade.nome
							this.lat_origin = response.data.latitude
							this.lon_origin = response.data.longitude
						}

					} else {

						// Erro
						if (!Object.keys(response.data).length) {
							this.city_destination = ''
							this.lat_destination = ''
							this.lon_destination = ''

						} else {
							this.city_destination = response.data.cidade.nome
							this.lat_destination = response.data.latitude
							this.lon_destination = response.data.longitude
						}
						
					}

					if (this.city_origin && this.city_destination) {
						this.calculateDistance()
					}
				})
			}
		},

		calculateDistance() {

			axios.post('api/cep/calculate/distance', {lat_orig: this.lat_origin,
													  lon_orig: this.lon_origin,
													  lat_dest: this.lat_destination,
													  lon_dest: this.lon_destination}
			).then(response => {
				this.distance = response.data + ' km'
			})

		},

		submitForm() {
			axios.put('ceps/' + this.id, {origin: this.origin,
										  destination: this.destination,
										  distance: this.distance.slice(0, -3)})
			.then(response => {
				this.originTitle = this.origin
				this.destinationTitle = this.destination
				this.message = 'Os dados foram editados com sucesso!'
				this.changeTitle = !this.changeTitle
				this.$parent.refresh()
			})
			
		},

		resetForm() {

			this.message = ''

		}
  	}
  
};
</script>