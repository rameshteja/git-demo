$(document).ready(function(){
    var t = $('#caetgory_listing_table').DataTable( {
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "columns":[
            {"width":"2%"},
            {"width":"2%"},
            null,
            {"width":"5%"},
            {"width":"2%"}
        ],
        "order": [[ 2, 'asc' ]]
    });
    t.on( 'order.dt search.dt', function () {
        t.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    var formData = {};
    formData['get_categories'] = 'all_categories';
    $.ajax({
        url:'category.php',
        method:'POST',
        data: formData,
        success:function(response){
            var cData = JSON.parse(response);
            var action = "";
            var status = '';
            if(cData){
                $.each(cData['message'],function(key,value){
                    var editClick = "edit_category_func("+value['category_id']+")";
                    action = '<a href="#" id="edit_category_'+value['category_id']+'" onclick="' + editClick + '"><i class="fas fa-pencil-alt"></i></a>&nbsp;&nbsp;';
                    action +='<a href="#" class="text-danger" id="delete_category_'+value['category_id']+'"><i class="fas fa-trash-alt"></i></a>';
                    if(value['status'] == 'active'){
                        status = '<td class="text-center"><span class="badge badge-success status_size">Active</span></div>';
                    }else{
                        status = '<td class="text-center"><span class="badge badge-danger status_size">Inactive</span></div>';
                    }
                    t.row.add(
                        [   
                            '<input type="checkbox" id="cat_id_'+value['category_id']+'" name = "category_id[]" value="'+value['category_id']+'">',
                            '',
                            value['category_name'],
                            status,
                            action  
                        ]);
                    t.draw();
                });
            }else{

            }
        }
    });

    $(document).on('click','[id^="delete_category_"]',function(){
        if(confirm('Are you sure you want to delete this item?')){
            var categoryArr = this.id.split('_');
            var $trr = $(this);
            var postData = {};
            postData['category_id'] = categoryArr[2];
            postData['category_single_delete'] = 'single delete';
            var table = $('#caetgory_listing_table').DataTable(); // replace with your table id 
            $.ajax({
                url: 'category.php',
                method: 'POST',
                data: postData,
                success: function(response){
                    var data = JSON.parse(response);
                    if(data){
                        $('.cat_error').html('<div class="alert alert-success" role="alert">'+data['message']+'</div>');
                        $trr.parents('tr').remove();
                    }else{
                        $('.cat_error').html('<div class="alert alert-danger" role="alert">'+data['message']+'</div>');
                    }
                }
            });
        }
    });
    

    $('#delete_all_category').click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    
    // add category
    $('#add_form_submit').click(function(){
        var postData = {};
        var category_name = $('#category_name').val();
        postData['status'] = $('#status').val();
        postData['category_name'] = category_name;
        postData['category_add'] = 'add_category';
        var mode = $('#category_mode').val();
        if(mode == 'add'){
            if(category_name != ''){
                $.ajax({
                    url: 'category.php',
                    method: 'POST',
                    data: postData,
                    success: function(response){
                        var data = JSON.parse(response);
                        if(data['status']){
                            $('#modelError').html('<span class="text-success">'+data['message']+'</span>');
                            $('#category_name').val('');
                        }else{
                            $('#modelError').html('<span class="text-danger">'+data['message']+'</span>');
                        }
                    }
                });
            }else{
                $('#categoryError').html('Category Name required');
            }
        }else if(mode == 'edit'){
            postData['category_id'] =  $('#category_id').val();
            postData['update_category_from'] = 'edit_category_from';
            if(category_name != ''){
                $.ajax({
                    url: 'edit_category.php',
                    method: 'POST',
                    data: postData,
                    success: function(response){
                        var data = JSON.parse(response);
                        if(data['status']){
                            $('#modelError').html('<span class="text-success">'+data['message']+'</span>');
                            // $('#category_name').val('');
                            $('#category_add_model').modal('toggle');
                        }else{
                            $('#modelError').html('<span class="text-danger">'+data['message']+'</span>');
                        }
                    }
                });
            }else{
                $('#categoryError').html('Category Name required');
            }
        }
        
    });

    $('#category_add_model').on('hidden.bs.modal', function () {
        location.reload();
      });

});
function edit_category_func(id){
 var formData = {};
 formData['edit_category'] = 'data';
 formData['category_id'] = id;
 $.ajax({
    url: 'category.php',
    method: 'POST',
     data: formData,
     success:function(response){
         var data = JSON.parse(response);
         console.log(data);
         if(data){
            $('#category_name').val(data['message']['category_name']);
            $('#category_id').val(data['message']['category_id']);
            $('#status').val(data['message']['status']);
            $('#category_mode').val('edit');
            $('#category_add_model').modal('show');
         }
         
     }
 });

}