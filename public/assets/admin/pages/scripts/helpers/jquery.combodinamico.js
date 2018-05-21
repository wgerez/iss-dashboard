(function($){
	$.fn.combodinamico = function(direccion, combocarga){
		$this = $(this)
		dire = direccion
		cbo = combocarga
		$this.change(function(){
			console.log($this.val());	
			$.ajax({
				type: "POST",
				url: dire,
				data: { id: $this.val() }	
				}).done(function(data) {
					console.log(data)
					combocarga.find('option').remove().end()
					combocarga.select2("destroy")
					for (i = 0; i < data.length; i++) {
						combocarga.append('<option value="'+data[i]['id']+'">'+data[i]['descripcion']+'</option>')
					}
					combocarga.select2()
				})
		})
	};
})(jQuery)