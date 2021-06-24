<template>
    <div id="refreshedModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
                <div class="modal-header">						
                    <h4 class="modal-title">Atualizado!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">	
                    <span> Todos os dados foram atualizados! </span>

                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">

                    <button type="submit" value="submit" data-dismiss="modal" class="btn btn-success">Ok</button>
                </div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
		};
	},
};
</script>