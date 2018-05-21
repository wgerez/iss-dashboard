

function primerFechaMayor(fecha1, fecha2) {
	var arrFecha1 = fecha1.split('/');
	var arrFecha2 = fecha2.split('/');
	var PrimerFecha = new Date(arrFecha1[2], arrFecha1[1], arrFecha1[0]);
	var SegundaFecha = new Date(arrFecha2[2], arrFecha2[1], arrFecha2[0]);

	return PrimerFecha.getTime() > SegundaFecha.getTime();
}