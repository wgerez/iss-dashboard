function calcular_edad(fecha) {
	var fechaActual = new Date()
	var diaActual = fechaActual.getDate();
	var mmActual = fechaActual.getMonth() + 1;
	var yyyyActual = fechaActual.getFullYear();
	FechaNac = fecha.split("/");
	var diaCumple = FechaNac[0];
	var mmCumple = FechaNac[1];
	var yyyyCumple = FechaNac[2];
	//retiramos el primer cero de la izquierda
	if (mmCumple.substr(0,1) == 0) {
	mmCumple= mmCumple.substring(1, 2);
	}
	//retiramos el primer cero de la izquierda
	if (diaCumple.substr(0, 1) == 0) {
	diaCumple = diaCumple.substring(1, 2);
	}
	var edad = yyyyActual - yyyyCumple;

	//validamos si el mes de cumpleaños es menor al actual
	//o si el mes de cumpleaños es igual al actual
	//y el dia actual es menor al del nacimiento
	//De ser asi, se resta un año
	if ((mmActual < mmCumple) || (mmActual == mmCumple && diaActual < diaCumple)) {
	edad--;
	}
	if (isNaN(edad)) { 
		return 0;
	}else{
		return edad;
	}	  
};