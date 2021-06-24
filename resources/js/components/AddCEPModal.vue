<template>
    <div id="addCEPModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form @submit.prevent="submitForm">		
					<div class="modal-header">						
						<h4 class="modal-title">Cadastrar Distância</h4>
						<button type="button" class="close" data-dismiss="modal" @click="resetForm" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">	
						<div class="form-group">

							<label>Origem</label> 
							<transition name="fade" mode="out-in" appear>
								<label class="red-color font-weight-bold" :key="city_origin">{{city_origin}}</label>
							</transition>

							<input @blur="handleBlur(origin, 'origin')" id="origin" type="text" maxlength="8" class="form-control" placeholder="Ex.: 89107000" v-model="origin" required autocomplete="off">
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

							<input @blur="handleBlur(destination, 'destination')" id="destination" type="text" maxlength="8" class="form-control" placeholder="Ex.: 89107000" v-model="destination" required autocomplete="off">
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

						<button type="submit" value="submit" class="btn btn-success" :disabled="!city_origin || !city_destination" >Cadastrar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
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
 		};
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
						console.log('oifdsfds')
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
				console.log(response)
				
				this.distance = response.data + ' km'
			})

		},

		submitForm() {
			console.log(this.origin, this.destination, this.distance)

			axios.post('ceps/', {origin: this.origin,
								 destination: this.destination,
								 distance: this.distance.slice(0, -3)}
			).then(response => {
				this.message = 'A distância de ' + this.city_origin + ' até ' + this.city_destination + ' foi salva!'
				this.$parent.refresh()
			})
		},
		resetForm() {
			this.origin = ''
			this.destination = ''
			this.distance = ''
			this.message = ''

			this.city_origin = ''
			this.lat_origin = ''
			this.lon_origin = ''
			this.city_destination = ''
			this.lat_destination = ''
			this.lon_destination = ''
		}
  	}
};
</script>