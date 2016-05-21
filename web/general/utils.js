function formatDate(date) {
	return moment(date).format('DD/MM/YYYY');
};

//llamo a gridResize en el resize del window
$(window).resize(gridResize)

function gridResize() {
	var $element = $(window);
	var dg = $('#dg');
	if (dg != undefined) {
		dg.datagrid('resize');
	}
	//haciendo cuentas..
	var datagrid = $(".datagrid-view")
	if (datagrid != undefined) {
		datagrid[0].style.height = $(window).height() - $('.datagrid-view').offset().top - 31+'px';
	}
}
