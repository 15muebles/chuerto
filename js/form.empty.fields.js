jQuery(function() { 
	var error;
	jQuery("#chuerto-form-content input[type=submit]").click(function() {
		jQuery("#chuerto-form-content .req").each(function() {
			if ( jQuery(this).val() == null || jQuery(this).val() == "" ) {
				error = true;
			}
		});
		if ( error == true ) {
			alert("Asegúrate de haber rellenado todos los campos requeridos antes de enviar el formulario.");
			error = false;
			return false;
		}
	});
});
