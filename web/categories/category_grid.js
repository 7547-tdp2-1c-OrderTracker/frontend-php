$("#dg").datagrid({
  loader: function(params, success, error) {
    $.ajax({
      url: window.apiBaseUrl + "/v1/categories?page=" + params.page + "&rows=" + params.rows,
      method: "GET",
      success: success,
      error: error,
      headers: {
        authorization: Cookies.get("tmtoken")
      }
    });
  }
});

var url ;
var method ;

function editCategory() {
  var row = $('#dg').datagrid('getSelected');
  if(row) {
    url = window.apiBaseUrl + "/v1/categories/" + row.id;
    method = "PUT";

    $('#dlg').dialog('open').dialog('setTitle','Editar Categoria');
    $('#fm').form('load',row);
  }
}

function newCategory() {
  url = window.apiBaseUrl + "/v1/categories";
  method = "POST";

  $('#dlg').dialog('open').dialog('setTitle','Nueva Categoria');
  $('#fm').form('clear');
}

function saveCategory() {
  $.ajax({
    url: url, 
    method: method, 
    data: {
      name: $(".category-form input[name='name']").val(),
      description: $(".category-form input[name='description']").val()
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
}

function deleteCategory() {
  var row = $('#dg').datagrid('getSelected');
  if(row) {
    $.ajax({
      url: window.apiBaseUrl + "/v1/categories/" + row.id,
      method: 'DELETE',
      headers: {
        authorization: Cookies.get("tmtoken")
      },
      success: function(result) {
        if(result.error) {
          $.messager.show({
            title: 'Error',
            msg: result.error.value
          });
        } else {
          $('#dlg').dialog('close');    // close the dialog
          $('#dg').datagrid('reload');  // reload the user data
        }
      }
    });
  }
}

$('#dg').datagrid({
  onDblClickCell: editCategory,
  onLoadSuccess: function(data){
    gridResize();
  }
});
