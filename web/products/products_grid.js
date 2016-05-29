var url, method;
var selectize_brand;
var selectize_categories;

var initSelectize = function() {
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

	if (selectize_categories) {
		selectize_categories[0].selectize.destroy();
	}
	selectize_categories = $('#fm input[name=categories]').selectize({
	  valueField: 'name',
	  labelField: 'name',
	  searchField: 'name',
	  delimiter: ',',
	  persist: false,
	  create: function(input) {
	      return {
	          name: input
	      }
	  },
		load: function(query, callback) {
	    var escape = function(str) {
	      return encodeURIComponent(str.replace(/\"/g, ''));
	    };
	    $.ajax({
	      url: window.apiBaseUrl + '/v1/categories?where={"name":{"$like":"%25'+escape(query)+'%25"}}',
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
	  }	  ,
		render: {
    	option_create: function(data, escape) {
      	return '<div class="create">Agregar <strong>' + escape(data.input) + '</strong>&hellip;</div>';
    	}
  	}	  
	});
};

function newProduct() {
	$('#dlg').dialog('open').dialog('setTitle','Nuevo Producto');
	$('#fm').form('clear');
	setImage("pictureImg", "");
	//url = 'products/create_product.php';
	method = 'POST';
	url = window.apiBaseUrl + "/v1/products";

	initSelectize();
  selectize_brand[0].selectize.setValue();
  
  //selectize_categories[0].selectize.setValue();
}


function editProduct() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		$('#dlg').dialog('open').dialog('setTitle','Editar Producto');
		$('#fm').form('load',row);
		setImage("pictureImg", row.picture);
		//url = 'products/edit_product.php?id='+row.id;

		method = 'PUT';
		url = window.apiBaseUrl + "/v1/products/" + row.id;


		initSelectize();

		if (row.brand) {
			selectize_brand[0].selectize.addOption({id: row.brand_id, name: row.brand.name});
			selectize_brand[0].selectize.setValue(row.brand_id);
		} else {
			selectize_brand[0].selectize.setValue();
		}

	  //selectize_categories[0].selectize.setValue(row.categories);

	}
}

function saveProduct() {
	var brand_id = $("#fm select[name='brand_id']").val(); 
	if (brand_id == "") {
    $.messager.show({
      title: 'Error',
      msg: "No se puede crear un producto sin marca"
    });

    return;
  }

  $.ajax({
    url: url, 
    method: method, 
    data: {
      name: $("#fm input[name='name']").val(),
      description: $("#fm input[name='description']").val(),
      picture: $("#fm input[name='picture']").val(),
      stock: $("#fm input[name='stock']").val(),
      currency: 'ARS',
      wholesalePrice: $("#fm input[name='wholesalePrice']").val(),
      retailPrice: $("#fm input[name='retailPrice']").val(),
      retailPrice: $("#fm input[name='retailPrice']").val(),
      brand_id: brand_id,
      categories: $("#fm input[name='categories']").val()
    },
    headers: {
      authorization: Cookies.get("tmtoken")
    },
    success: function(result) {
      $('#dlg').dialog('close');    // close the dialog
      $('#dg').datagrid('reload');  // reload the user data
    },
    error: function(xhr) {
      $.messager.show({
        title: 'Error',
        msg: xhr.responseJSON.error ? xhr.responseJSON.error.value : "Error desconocido"
      });
   	}
  });	
	/*$('#fm').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('('+result+')');
			if(result.errorMsg) {
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			} else {
				$('#dlg').dialog('close');		// close the dialog
				$('#dg').datagrid('reload');	// reload the user data
			}
		}
	});*/
}

function deleteProduct() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		$.messager.confirm('Confirm','¿Está seguro de que desea eliminar '+row.name+'?',function(r){
			if (r){
				$.post('products/delete_product.php',{id:row.id},function(result){
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

function formatPicture(value,row,index) {
	var size = 50;
	return '<img src="'+row.picture+'" style="width: '+size+'px; height: '+size+'px"/>';
}

function formatPrice(val, row) {
    return "$"+val;
}

$("[name='picture']").bind('change', function(e) {
	setImage("pictureImg", $(this).val());
});

$("#pictureImg").error(function() {
    $(this).attr("src", "images/noimage.png");
    $("[name='picture']").css("background-color", "#fff3f3");
});

function setImage(image, src) {
	if(!src || src.length === 0) {
		src = "images/noimage.png";
	}

	$("#"+image).attr("src", src);
	$("[name='picture']").css("background-color", "white");
}

$('#brands-combo').combobox({
    url:'brands/get_brands.php',
    valueField:'id',
    textField:'name',
    onSelect:function(brand) {
    	$("[name='brand_id']").val(brand.id);
    }
});

$('#dg').datagrid({
	onDblClickCell: editProduct,
	onLoadSuccess: function(data){
		gridResize();
	}
});
