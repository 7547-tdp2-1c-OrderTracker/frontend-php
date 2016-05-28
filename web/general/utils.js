function formatDate(date) {
	return moment(date).format('DD/MM/YYYY');
};

//si hay un resize de pantalla, disparo evento cada medio segundo
var $element = $(window), lastWidth = $element.width(), lastHeight = $element.height();
//llamo a gridResize en el resize del window
$(window).resize(gridResize)
function gridResize() {
	var dg = $('#dg');
	if (dg != undefined && dg.datagrid != null) {
		dg.datagrid('resize');
	}
	//haciendo cuentas..
	var datagrid = $(".datagrid-view")
	if (datagrid != undefined && datagrid.length > 0) {
		datagrid[0].style.height = $(window).height() - $('.datagrid-view').offset().top - 31+'px';
	}
}
