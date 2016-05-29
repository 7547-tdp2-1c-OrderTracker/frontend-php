var url;
var current_discount_id;
var selectize_product;
var selectize_brand;

function formatRestriction(entity, row) {
	if (row.product) {
		return "Producto: " + row.product.name;
	} else if (row.brand) {
		return "Marca: " + row.brand.name;
	} else {
		return "";
	}
}

var initSelectize = function() {
	selectize_product = $('#select-product').selectize({
	  valueField: 'id',
	  labelField: 'name',
	  searchField: 'name',
	  options: [],
	  create: false,
	  load: function(query, callback) {
	    var escape = function(str) {
	      return encodeURIComponent(str.replace(/\"/g, ''));
	    };
	    $.ajax({
	      url: window.apiBaseUrl + '/v1/products?where={"name":{"$like":"%25'+escape(query)+'%25"}}',
	      type: 'GET',
				headers: {
					authorization: Cookies.get("tmtoken")
				},
	      error: function() {
	          callback();
	      },
	      success: function(res) {
	          callback(res.results);
	      }
	    });          
	  }
	});

	selectize_brand = $('#select-brand').selectize({
	  valueField: 'id',
	  labelField: 'name',
	  searchField: 'name',
	  options: [],
	  create: false,
	  load: function(query, callback) {
	    var escape = function(str) {
	      return encodeURIComponent(str.replace(/\"/g, ''));
	    };
	    $.ajax({
	      url: window.apiBaseUrl + '/v1/brands?where={"name":{"$like":"%25'+escape(query)+'%25"}}',
	      type: 'GET',
				headers: {
					authorization: Cookies.get("tmtoken")
				},      
	      error: function() {
	          callback();
	      },
	      success: function(res) {
	          callback(res.results);
	      }
	    });          
	  }
	});	
};

function newDiscount() {
	$('#dlg').dialog('open').dialog('setTitle','Nuevo Descuento');
	$('#fm').form('clear');
	setDate("begin", new Date());
	url = 'discounts/create_discount.php';

	initSelectize();
  selectize_product[0].selectize.setValue();
  selectize_brand[0].selectize.setValue();

  current_discount_id = null;
}

function editDiscount() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		$('#dlg').dialog('open').dialog('setTitle','Editar Descuento');
		$('#fm').form('load',row);
		setDate("begin", row.begin_date);
		setDate("end", row.end_date);

		initSelectize();

		if (row.product) {
			selectize_product[0].selectize.addOption({id: row.product_id, name: row.product.name});
			selectize_product[0].selectize.setValue(row.product_id);
		} else {
			selectize_product[0].selectize.setValue();
		}

		if (row.brand) {
			selectize_brand[0].selectize.addOption({id: row.brand_id, name: row.brand.name});
			selectize_brand[0].selectize.setValue(row.brand_id);
		} else {
			selectize_brand[0].selectize.setValue();
		}




		url = 'discounts/edit_discount.php?id='+row.id;
		current_discount_id = row.id;
	}
}

function saveDiscount() {
	var data = {
			product_id: $("select[name=product_id]").val(),
			name: $("input[name=name]").val(),
			percent: $("input[name=percent]").val(),
			begin_date: $("input[name=begin_date]").val(),
			end_date: $("input[name=end_date]").val(),
			min_quantity: $("input[name=min_quantity]").val()
	};

	if (!data.product_id) {
			data.brand_id = $("select[name=brand_id]").val();
	}

	var url, method;
	if (current_discount_id) {
		url = window.apiBaseUrl + "/v1/promotions/" + current_discount_id;
		method = "PUT";
	} else {
		url = window.apiBaseUrl + "/v1/promotions";
		method = "POST";
	}

	$.ajax({
		url: url,
		method: method,
		headers: {
			authorization: Cookies.get("tmtoken")
		},
		data: data
	}).then(function(result) {
			if(result.errorMsg) {
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			} else {
				$('#dlg').dialog('close');		// close the dialog
				$('#dg').datagrid('reload');	// reload the user data
			}
	});

}

function deleteDiscount() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		$.messager.confirm('Confirm','¿Está seguro de que desea eliminar '+row.name+'?',function(r){
			if (r){
				$.post('discounts/delete_discount.php',{id:row.id},function(result){
					if (result.success){
						$('#dg').datagrid('reload');   // reload the user data
					} else {
						$.messager.show({	// show error message
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		});
	}
}

function setDate(field, date) {
	$('#'+field).datebox('setValue', formatDate(date));

	var saveFormat = moment(date).format('YYYY-MM-DD')+'T00:00:00.000Z';
	$("[name='"+field+"_date']").val(saveFormat);
}

$('#begin').datebox({
	onSelect: function(date) {
		setDate("begin", date);
	}
});

$('#end').datebox({
	onSelect: function(date) {
		setDate("end", date);
	}
});


$('#dg').datagrid({
	onDblClickCell: editDiscount,
	onLoadSuccess: function(data){
		gridResize();
	}
});
