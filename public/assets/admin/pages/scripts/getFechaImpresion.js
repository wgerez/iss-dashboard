/*
 * Recibe FechaHora en formato aaaa-mm-dd hh:mm:ss
 * Devuelve fecha en formato dd/mm/aaaa
 */
function getFechaImpresion(fecha) {
    if (fecha.trim() == "") return;
    var arr_fecha_hora = fecha.split(" ");
	var arr_fecha = arr_fecha_hora[0].split("-");
	var result = arr_fecha[2] + "/" + arr_fecha[1] + "/" + arr_fecha[0]
	return result;
}