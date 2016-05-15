function formatPrice(val, row) {
    return val;  // si se cambia rompe el filtro
}

function formatDate(date) {
	return moment(date).format('DD/MM/YYYY');
};

