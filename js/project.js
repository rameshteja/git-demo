$(document).ready(function(){
    $('.dleteErrmsg').html('');
    var t = $('#table_id').DataTable( {
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "columns": [
            { "width": "2%" },
            { "width": "2%" },
            null,
            null,
            null,
            null,
            null,
            null
          ],
        "order": [[ 1, 'asc' ]]
    } );

    t.on( 'order.dt search.dt', function () {
        t.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    $('#checkAll').click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    // $('#js-dynamic-row-btn').append();

// $("#addProductForm").validate();
    load_rules();
    load_categories(1);
});
function load_rules(){
    //   form validation using jquery validate method
    $("#addProductForm").validate({
        rules: {
            'name[]': {
                required: true
            },
            'category[]': {
                required: true
            },
            'price[]':{
                required:true
            },
            'rating[]':{
                required: true
            },
            'quantity[]':{
                required: true
            },
            'status[]':{
                required:true
            },
            'code[]': {
                required: true,
                remote: {
                    url: "user_db.php",
                    type: "post",
                  }               
            }
            
        },
        messages: {
            'name[]': {
                required: "username required"
                
            },
            'category[]':{
                required: "categoty required"
            },
            'price[]':{
                required: "Price required"
            },
            'rating[]':{
                required: "Rating required"
            },
            'quantity[]':{
                required: "quantity required"
            },
            'status[]':{
                required: "status required"
            },
            'code[]': {
                required: "code required",
                remote: "Code already taken"
            }
            
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "name[]") {
                $('#err' + element.attr('id')).html(error);
            }
            if (element.attr("name") == "category[]") {
                $('#err' + element.attr('id')).html(error);
            }
            if (element.attr("name") == "price[]") {
                $('#err' + element.attr('id')).html(error);
            }
            if (element.attr("name") == "rating[]") {
                $('#err' + element.attr('id')).html(error);
            }
            if (element.attr("name") == "quantity[]") {
                $('#err' + element.attr('id')).html(error);
            }
            if (element.attr("name") == "status[]") {
                $('#err' + element.attr('id')).html(error);
            }
            if (element.attr("name") == "code[]") {
                console.log(element.attr('id'));
                $('#err' + element.attr('id')).html(error);
            }
        }
    });
}
function validate(){
    $('#emailError').html('');
    $('#passwordError').html('');
    var email = $('#email').val();
    var password = $('#password').val();
    var msg = '';
    //email validation
    if(email == ''){
        $('#emailError').html('Email required');
        msg += 'Email required, ';
    }
    // password validation
    if(password == ''){
        $('#passwordError').html('Password required');
        msg += 'Password required';
    }
    if(msg == ''){
        return true;
    }else{
        return false;
    }
}

// password reset validations
function validate_resetPassword(){
    $('#newPasswordError').html('');
    $('#oldPasswordError').html('');
    $('#cPasswordError').html('');
    
    var old_password = $('#old_password').val();
    var new_password = $('#new_password').val();
    var confirm_password = $('#confirm_password').val();
    var msg = '';
    if(old_password == ''){
        $('#oldPasswordError').html('Old password required...!');
        msg += 'error';
    }
    if(new_password == ''){
        $('#newPasswordError').html('New Password required...!');        
        msg += 'error';
    }
    if(confirm_password == ''){
        $('#cPasswordError').html('Confirm Password required...!');
        msg += 'error';
    }
    
    if(msg == ''){
        return true;
    }else{
        return false;
    }
}

// user registration validations
function validate_userRegister(){
    $('#userNameError').html();
    $('#userEmailError').html();
    $('#genderError').html();
    $('#mobileError').html();
    $('#dobError').html();
    $('#passwordError').html();
    var msg = '';
    var name = $('#userName').val();
    var email = $('#userEmail').val();
    var gender = $('#gender').val();
    var mobile = $('#mobile').val();
    var dob = $('#dob').val();
    var password = $('#password').val();

    // USER NAME VALIDATION
    if(name == ''){
        $('#userNameError').html('User Name require');
        msg += 'error';
    }
    //EMAIL VALIDATION
    if(email == ''){
        $('#userEmailError').html('User Email require');
        msg += 'error';
    }

    if(gender == ''){
        $('#genderError').html('Gender require');
        msg += 'error';
    }

    if(mobile == ''){
        $('#mobileError').html('Mobile require');
        msg += 'error';
    }

    if(dob == ''){
        $('#dobError').html('DOB require');
        msg += 'error';
    }

    // password validation
    if(password == ''){
        $('#passwordError').html('Password require');
        msg += 'error';
    }

    if(msg == ''){
        return true;
    }else{
        return false;
    }
}

// add product validations
function validate_addProduct(){
    $('#nameError').html();
    $('#categoryError').html();
    $('#priceError').html();
    $('#ratingError').html();
    $('#statusError').html();
    $('#quantityError').html();
    var msg = '';

    var name = $('#name').val();
    var category = $('#category').val();
    var price = $('#price').val();
    var rating = $('#rating').val();
    var quantity = $('#quantity').val();
    var status = $('#status').val();
    if(name == ''){
        $('#nameError').html('Name require');
        msg = 'error';
    }

    if(category == ''){
        $('#categoryError').html('Category require');
        msg = 'error';
    }
    if(price == ''){
        $('#priceError').html('Price require');
        msg = 'error';
    }
    if(rating == ''){
        $('#ratingError').html('Rating require');
        msg = 'error';
    }
    if(quantity == ''){
        $('#quantityError').html('Quantity require');
        msg = 'error';
    }
    if(status == ''){
        $('#statusError').html('Status require');
        msg = 'error';
    }

    if(msg == ''){
        return true;
    }else{
        return false;
    }
}

// edit product validations
function validate_editProduct(){
    $('#nameError').html();
    $('#categoryError').html();
    $('#priceError').html();
    $('#ratingError').html();
    $('#statusError').html();
    $('#quantityError').html();
    var msg = '';

    var name = $('#name').val();
    var category = $('#category').val();
    var price = $('#price').val();
    var rating = $('#rating').val();
    var quantity = $('#quantity').val();
    var status = $('#status').val();
    if(name == ''){
        $('#nameError').html('Name require');
        msg = 'error';
    }

    if(category == ''){
        $('#categoryError').html('Category require');
        msg = 'error';
    }
    if(price == ''){
        $('#priceError').html('Price require');
        msg = 'error';
    }
    if(rating == ''){
        $('#ratingError').html('Rating require');
        msg = 'error';
    }
    if(quantity == ''){
        $('#quantityError').html('Quantity require');
        msg = 'error';
    }
    if(status == ''){
        $('#statusError').html('Status require');
        msg = 'error';
    }

    if(msg == ''){
        return true;
    }else{
        return false;
    }
}

// add dynamic row
function add_new_row(){
    var c_id = $('.product_body tr:last').attr('id');
    var idArr = c_id.split('_');
    var id = parseInt(idArr[1]) + 1; 
    var data = '';
    data +='<tr id="row_'+id+'" class="product_row">';
        data +='<td>';
            data +='<input type="text" name="name[]" id="name_'+id+'" class="form-control" onkeyup = "copytext(this);" placeholder="Product Name">';
            data +='<div class="errormsg" id="errname_'+id+'" >';

        data +='</td>';
        data +='<td>';
            data +='<input type="text" name="code[]" id="code_'+id+'" class="form-control" placeholder="Product Code">';
            data +='<div class="errormsg" id="errcode_'+id+'" >';
        data +='</td>';
        data +='<td>';
            data +='<select name="category[]" id="category_'+id+'" class="form-control">';
                    
            data +='</select>';
            data +='<div class="errormsg" id="errcategory_'+id+'" ></div>';

        data +='</td>';
        data +='<td>';
            data +='<input style="width:90px" type="text" name="price[]" id="price_'+id+'" class="form-control" placeholder="Price">';
            data +='<div class="errormsg" id="errprice_'+id+'" ></div>';
        data +='</td>';
        data +='<td>';
            data +='<input style="width:90px"  type="text" name="rating[]" id="rating_'+id+'" class="form-control" placeholder="Rating">';
            data +='<div class="errormsg" id="errrating_'+id+'" ></div>';
        data +='</td>';
        
        data +='<td>';
            data +='<select name="status[]" id="status_'+id+'" class="form-control c_status">';
                    data +='<option value="yes">Available</option>';
                    data +='<option value="no">UnAvailable</option>';
            data +='</select>';
            data +='<div class="errormsg" id="errstatus_'+id+'" ></div>';
        data +='</td>';
        data +='<td><button type="button" class="btn btn-danger" onclick="delete_row(this)"><i class="far fa-trash-alt"></i></button></td>';
    data +='</tr>';
    $('.product_body').append(data);
    load_categories(id);
    load_rules();
}

// deleting row
function delete_row(element){
    element.parentNode.parentNode.remove();
}

function load_categories(id){
    var formData = {};
    formData['category_get'] = 'categories';
    $.ajax({
        url: 'user_db.php',
        method: 'POST',
        async: false,
        data : formData,
        success:function(response){
            var pData = JSON.parse(response);
            // console.log(pData);
            var data = '<option value="">select category</option>';
            $.each(pData['data'],function(index,value){
                data += '<option value="'+value['category_id']+'">'+value['category_name']+'</option>';
            });
            $('#category_'+id).html(data);
            
        }
    });
}
function copytext(element){
    var id = element.id;
    var idArr = id.split('_')
        $("#code_"+idArr[1]).val($("#"+id).val().replace(/ /g, '_'));
}

// function for deleting products
$(document).on('click', '[id^="delete-product-"]', function() {
    var $button = $(this);
    var id = this.id.split('-').pop();
    $('.deleteErrmsg').html('');
    var formData = {};
    var con = confirm('Are you sure you want to delete this item?');
    formData['delete_product'] = 'delete_single';
    formData['id'] = id;
    var table = $('#table_id').DataTable(); // replace with your table id 
    if(con){
        $.ajax({
            url: 'delete_product.php',
            method: 'POST',
            data: formData,
            success:function(response){
                var dbdata = JSON.parse(response);
                console.log(response);
                if(dbdata){
                    $('.deleteErrmsg').html('<div class="alert alert-success" role="alert">'+dbdata['message']+'</div>');
                    $button.parents('tr').remove();
                }else{
                    $('.deleteErrmsg').html('<div class="alert alert-danger" role="alert">'+dbdata['message']+'</div>');
                }
            }
        });
    }
});
// add category
$('#add_form_submit').click(function(){
    var postData = {};
    var category_name = $('#category_name').val();
    postData['status'] = $('#status').val();
    postData['category_name'] = category_name;
    postData['category_add'] = 'add_category';
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
                    $('#category_add_model_1').modal('hide');
                }else{
                    $('#modelError').html('<span class="text-danger">'+data['message']+'</span>');
                }
            }
        });
    }else{
        $('#categoryError').html('Category Name required');
    }
});

$('#category_add_model').on('hidden.bs.modal', function () {
    location.reload();
  });