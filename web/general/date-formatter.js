$.extend($.fn.datebox.defaults,{
	formatter:function(date){
		return moment(date).format("DD/MM/YYYY");
	},
	parser:function(s){
		if (!s) return new Date();
		return moment(s, "DD/MM/YYYY").toDate();
	}
});