var permission_id = localStorage.getItem('staff_id');
// load categories in tree format
get_tree_categories();
get_extra_options_data();
$(document).ready(function () {
	// to set min date today for expiry date.
	expiry_date.min = new Date().toISOString().split("T")[0];
	formData = {};
	formData['api_key'] = apiKey;
	if (permission_id != null) {
		formData['permission_id'] = permission_id;
	}
	var arr = {},
		i = 0;
	// to get variant data in select options
	load_variants('select_variant');

	get_display_plugins('products_add');
	
});
//deynamic image elements creation  
function add_moreImages() {
	$('.js-cloning-object')
		.clone()
		.appendTo('.js-cloning-object-container');
}

$(document).on("click", ".js-remove-handle", function (e) {

	$(this).parents(".js-container").remove();

});

$('input[name="expiry"]').click(function () {
	var expiry = $("input[name='expiry']:checked").val();
	if (expiry == '1') {
		$('#js-expiry-date').removeClass('d-none');
	} else {
		$('#js-expiry-date').addClass('d-none');
	}
});

$('.js-cost-margin').change(function(){
	var unit_type = $('#unit_type').val();
	var cost = parseFloat($('.js-non-variant-' + unit_type + '-div #cost').val());
	var margin = parseFloat($('.js-non-variant-' + unit_type + '-div #margin').val());
	var margin_type = $('.js-non-variant-' + unit_type + '-div #margin_type').val();
	var price = $('.js-non-variant-' + unit_type + '-div #price').val();

	if(!isNaN(cost) && cost!='' && !isNaN(margin) && margin!=''){
		// for price = cost + margin
		if(margin_type == 'percentage'){
			price = (margin / 100) * cost;
			if(isNaN(price) || price == 'Infinity'){	price = 0;	}
			price += cost;
		}else{
			price = cost + margin;
		}
		if(isNaN(price) || price == 'Infinity'){	price = 0;	}
		$('.js-non-variant-' + unit_type + '-div #price').val(price.toFixed(2));
	}else if(!isNaN(price) && price!='' && !isNaN(margin) && margin!=''){
		// for cost = price - margin %|$
		if(margin_type == 'percentage'){
			margin = (margin / 100) * price;
			// if(isNaN(price) || price == 'Infinity'){	price = 0;	}
			cost = price - margin;
		}else{
			cost = price - margin;
		}
		if(isNaN(cost) || cost == 'Infinity'){	cost = 0;	}
		$('.js-non-variant-' + unit_type + '-div #cost').val(cost.toFixed(2));
	}else if(!isNaN(price) && price!='' && !isNaN(cost) && cost !=''){
		// for margin = price - cost
		if(margin_type == 'percentage'){
			cost = (cost / 100) * price;
			margin = price - cost;
		}else{
			margin = price - cost;
		}
		if(isNaN(margin) || margin == 'Infinity'){	margin = 0;	}
		$('.js-non-variant-' + unit_type + '-div #margin').val(margin.toFixed(2));
		// $('.js-non-variant-' + unit_type + '-div #margin_type').val('currency');
	}

});

function variantCostChange(ele,parents){
	var tableRow = $(ele).parent().parent().attr("id");
	if(parents){
		tableRow = $(ele).parent().parent().parent().attr("id");
	}
	console.log(tableRow);
	var cost = parseFloat($('#'+tableRow+' #cost').val());
	var margin = parseFloat($('#'+tableRow+' #margin').val());
	var margin_type = $('#'+tableRow+' #margin_type').val();
	var price = $('#'+tableRow+' #price').val();

	if(!isNaN(cost) && cost!='' && !isNaN(margin) && margin!=''){
		// for price = cost + margin
		if(margin_type == 'percentage'){
			price = (margin / 100) * cost;
			if(isNaN(price) || price == 'Infinity'){	price = 0;	}
			price += cost;
		}else{
			price = cost + margin;
		}
		if(isNaN(price) || price == 'Infinity'){	price = 0;	}
		$('#'+tableRow+' #price').val(price.toFixed(2));
	}else if(!isNaN(price) && price!='' && !isNaN(margin) && margin!=''){
		// for cost = price - margin %|$
		if(margin_type == 'percentage'){
			margin = (margin / 100) * price;
			cost = price - margin;
		}else{
			cost = price - margin;
		}
		if(isNaN(cost) || cost == 'Infinity'){	cost = 0;	}
		$('#'+tableRow+' #cost').val(cost.toFixed(2));
	}else if(!isNaN(price) && price!='' && !isNaN(cost) && cost !=''){
		// for margin = price - cost
		if(margin_type == 'percentage'){
			cost = (cost / 100) * price;
			margin = price - cost;
		}else{
			margin = price - cost;
		}
		if(isNaN(margin) || margin == 'Infinity'){	margin = 0;	}
		$('#'+tableRow+' #margin').val(margin.toFixed(2));
	}
}

$('.js-cost-margin-type').change(function(){
	var unit_type = $('#unit_type').val();
	$('.js-non-variant-' + unit_type + '-div #cost').val('0.00');
	$('.js-non-variant-' + unit_type + '-div #price').val('0.00');
	$('.js-non-variant-' + unit_type + '-div #margin').val('0.00');
});

function marginChange(ele){
	var tableRow = $(ele).parent().parent().parent().parent().attr("id");
	$('#'+tableRow+' #cost').val('0.00');
	$('#'+tableRow+' #price').val('0.00');
	$('#'+tableRow+' #margin').val('0.00');
}

// submiting products form data
function product_add() {
	var data = new FormData();
	
	// Read selected files
	var totalfiles = document.getElementById('images').files.length;
	if(totalfiles){
		for (var index = 0; index < totalfiles; index++) {
			data.append("images[]", document.getElementById('images').files[index]);
		}
	}else{
		data.append("images[]",[]);
	}
	
	for (var pair of data.entries()) {
		console.log(pair[0] + ', ' + pair[1]);
	}

	var msg = '';
	var unit_type = $('#unit_type').val();
	var expiry = $("input[name='expiry']:checked").val();
	if (expiry == '1') {
		var expiry_date = $('#expiry_date').val();
		if (expiry_date == '') {
			msg += 'Expiry date Required <br>';
		} else {
			data.append('expiry', expiry);
			data.append('expiry_date', expiry_date);
		}
	} else {
		data.append('expiry', expiry);
		data.append('expiry_date', '');
	}

	$("#js-products-add").find("[name]").each(function (index, value) {
		var thisForm = $(this),
			fieldName = thisForm.attr("name"),
			fieldValue = thisForm.val();
		if (fieldName != 'product_images[]' && fieldName != 'sku' && fieldName != 'expiry_date' && fieldName != 'extra_option[]' && fieldName != 'barcode' && fieldName != 'price' && fieldName != 'quantity' && fieldName != 'variant_option[]' && fieldName != 'images[]' && fieldName != 'cost' && fieldName != 'margin') {
			if (fieldValue == '') {
				msg += fieldName + " required <br>";
			}
		}
	});
	var values = $("input[name='product_images[]']")
		.map(function () { return $(this).val(); }).get();
	var img = {};
	var valueCount = values.length;
	for (p = 0; p < valueCount; p++) {
		img[p] = values[p];
	}
	// formData['images'] = img;

	if ($("#featured").is(":checked")) {
		data.append('featured_category', 'yes');
	} else {
		data.append('featured_category', 'no');
	}
	var categories = $("select[name='category_id[]']").map(function () {
		return $(this).val();
	}).get();
	// extra options 
	var extra_option_data = $("select[name='extra_option[]']").map(function () {
		return $(this).val();
	}).get();
	data.append('extra_options', extra_option_data.toString());
	// categories selected ids getting
	var categoriesArry = [];
	$(".js-categories-list input:checkbox").each(function () {
		if ($(this).is(":checked")) {
			categoriesArry.push($(this).attr('id'));
		}
	});
	var categories_ids = '';
	categories_ids = categoriesArry.toString();
	if ($('#product_type').val() == 'non-variant') {
		// non-variant
		if ($('.js-non-variant-' + unit_type + '-div #cost').val() == '') {
			msg += 'cost required, <br>';
		} else {
			var cost = $('.js-non-variant-' + unit_type + '-div #cost').val();
		}
		if ($('.js-non-variant-' + unit_type + '-div #margin').val() == '') {
			msg += 'margin required, <br>';
		} else {
			var margin = $('.js-non-variant-' + unit_type + '-div #margin').val();
		}
		if ($('.js-non-variant-' + unit_type + '-div #margin_type').val() == '') {
			msg += 'margin_type required, <br>';
		} else {
			var margin_type = $('.js-non-variant-' + unit_type + '-div #margin_type').val();
		}
		if ($('.js-non-variant-' + unit_type + '-div #price').val() == '') {
			msg += 'price required, <br>';
		} else {
			var price = $('.js-non-variant-' + unit_type + '-div #price').val();
		}
		if ($('.js-non-variant-' + unit_type + '-div #quantity').val() == '') {
			msg += 'quantity required <br>';
		} else {
			var quantity = $('.js-non-variant-' + unit_type + '-div #quantity').val();
		}
		if ($('.js-non-variant-' + unit_type + '-div #sku').val() == '') {
			msg += 'sku required <br>';
		} else {
			var sku = $('.js-non-variant-' + unit_type + '-div #sku').val();
		}
		if ($('.js-non-variant-' + unit_type + '-div #barcode').val() == '') {
			msg += 'barcode required <br>';
		} else {
			var barcode = $('.js-non-variant-' + unit_type + '-div #barcode').val();
		}
		if (unit_type == 'weight') {
			if ($('.js-non-variant-' + unit_type + '-div #measurement').val() == '') {
				msg += 'measurement required <br>';
			} else {
				var measurement = $('.js-non-variant-' + unit_type + '-div #measurement').val();
			}
			data.append('measurement', measurement);
		}
		
		data.append('cost', cost);
		data.append('margin', margin);
		data.append('margin_type', margin_type);
		data.append('price', price);
		data.append('quantity', quantity);
		data.append('sku', sku);
		data.append('barcode', barcode);
		
	} else {
		if ($('.js-variant-price-div').html() != '') {
			$(".js-variant-price-div").find("[name]").each(function (index, value) {
				var thisForm = $(this),
					fieldName = thisForm.attr("name"),
					fieldValue = thisForm.val();
				if (fieldValue == '') {
					msg += fieldName + " required <br>";
				}
			});

			if (msg == '') {

				var main_variants = get_selected_variant_data();
				var variant_names = $(".js-variant-price-div input[name='variant[]']")
					.map(function () { return $(this).val(); }).get();
				var prices = $(".js-variant-price-div input[name='price[]']")
					.map(function () { return $(this).val(); }).get();
				var quantity = $(".js-variant-price-div input[name='quantity[]']")
					.map(function () { return $(this).val(); }).get();
				var sku = $(".js-variant-price-div input[name='sku[]']")
					.map(function () { return $(this).val(); }).get();
				var measurement = $(".js-variant-price-div select[name='measurement[]']")
					.map(function () { return $(this).val(); }).get();
				var barcode = $(".js-variant-price-div input[name='barcode[]']")
					.map(function () { return $(this).val(); }).get();
				var cost = $(".js-variant-price-div input[name='cost[]']")
					.map(function () { return $(this).val(); }).get();
				var margin = $(".js-variant-price-div input[name='margin[]']")
					.map(function () { return $(this).val(); }).get();
				var margin_type = $(".js-variant-price-div select[name='margin_type[]']")
					.map(function () { return $(this).val(); }).get();
				var variant_price_data = {};
				var iterate = 0;
				
				$.each(variant_names, function (key, value) {
					var variant_data = {};
					variant_data['variants'] = value;
					variant_data['price'] = prices[iterate];
					variant_data['quantity'] = quantity[iterate];
					variant_data['sku'] = sku[iterate];
					variant_data['barcode'] = barcode[iterate];
					variant_data['cost'] = cost[iterate];
					variant_data['margin'] = margin[iterate];
					variant_data['margin_type'] = margin_type[iterate];
					if (unit_type == 'weight') {
						variant_data['measurement'] = measurement[iterate];
					}
					variant_price_data[iterate] = variant_data;
					iterate++;
				});
				var finalData = {};
				finalData['variants'] = main_variants;
				finalData['variant_quantity_prices'] = variant_price_data;

				var finalData = JSON.stringify(finalData);
				data.append('variants', finalData);

			} else {

			}
		} else {
			swal({
				title: "Error!",
				text: 'Variant Price Fields Required',
				icon: "error",
				buttons: {
					confirm: {
						text: "Close",
						value: true,
						visible: true,
						className: "btn btn-lg btn-gradient-01",
						closeModal: true
					}
				}
			});
		}
	}
	
	data.append('api_key', apiKey);
	data.append('unit_type', $('#unit_type').val());
	data.append('product_type', $('#product_type').val());
	data.append('category_id', categories_ids);
	
	if (msg == '') {
		data.append('api_key', apiKey);
		data.append('unit_type', $('#unit_type').val());
		data.append('product_type', $('#product_type').val());
		if (permission_id != null) {
			data.append('permission_id', permission_id);
		}
		// data.append('category_id', categories.toString());
		data.append('category_id', categories_ids);
		data.append('name', $('#name').val());
		data.append('description', $('#description').val());
		data.append('platform', $('#platform').val());
		
		//  Ajax Call for saving the data
		$.ajax({
			url: apiBaseUrl + 'products/add',
			type:'POST',
			data:data,
			processData: false,
			contentType: false,
			cache: false,
			success: function (response) {
				// "Parsing JSON" output 
				returnedData = JSON.parse(response);
				if (returnedData.status) {
					swal({
						title: "Success",
						text: returnedData.message,
						icon: "success",
						buttons: {
							confirm: {
								text: "Close",
								value: true,
								visible: true,
								className: "btn btn-lg btn-gradient-01",
								closeModal: true
							}
						}
					}).then((value) => {
						$('#product_id').val(returnedData.product_id);
						$('#profile-tab').attr('data-toggle','tab');
						$('#profile-tab').attr('href','#profile');
						$('#profile-tab').attr('role','#tab');
						$('.nav-tabs a[href="#profile"]').tab('show');
						get_display_plugins('products_add');
						// window.location = 'products_retrieve';
					});
				} else {
					swal({
						title: "Error!",
						text: returnedData.message,
						icon: "error",
						buttons: {
							confirm: {
								text: "Close",
								value: true,
								visible: true,
								className: "btn btn-lg btn-gradient-01",
								closeModal: true
							}
						}
					});
					$('#form_errors').html("<u>Errors:</u><br>" + returnedData.message);
					var elmnt = document.getElementById("reg_account");
					elmnt.scrollIntoView();
				}
			}
		});


		// Re Setting all variable & JS Object(s)
		formData = {};

	}
	else {
		swal({
			title: "Error!",
			text: msg.split('<br>').join(', '),
			icon: "error",
			buttons: {
				confirm: {
					text: "Close",
					value: true,
					visible: true,
					className: "btn btn-lg btn-gradient-01",
					closeModal: true
				}
			}
		});
	}

}

// to set fields according to product type
function product_type_click() {
	var type = $('#product_type').val();
	if (type == 'variant') {
		$('.js-non-variant-unit-div').hide();
		$('#js-non-variant-weight-div').hide();
		$('#js-non-variant-dimentions-div').hide();
		$('.js-variant-div').show();
		// $('.js-variant-price-div').hide();
	} else {
		select_type();
		// $('.js-non-variant-unit-div').show();
		$('.js-variant-div').hide();
		$('.js-variant-price-div').hide();
	}
}

// to add variant option row in design
function add_variant_option(element) {
	$(element).attr('onclick', 'del_variant_option(this)');
	$(element).html('<i class="fa fa-trash mr-0"></i>');
	var data = '<div class="row">';
	data += '<div class="col-lg-8">';
	data += '<input id="variant_options" type="text" placeholder="Ex: Red" name="variant_options[]" value="" class="form-control">';
	data += '</div>';
	data += '<div class="col-lg-2">';
	data += '<span class="btn btn-lg btn-gradient-02" onclick="add_variant_option(this)"><i class="fa fa-plus mr-0"></i></span>';
	data += '</div>';
	data += '</div>';
	$('.js-variant-add-options').prepend(data);
}

// to del variant option row in design
function del_variant_option(d) {
	d.parentNode.parentNode.remove();
}

function add_multiple_variants(element) {
	// $(element).attr('onclick','del_multiple_variant(this)');
	// $(element).html('x');
	var incre_num = $('.js-variant-append-div .row').length;
	incre_num = incre_num + 1;
	var onclick = "get_variant_options('select_variant_" + incre_num + "','variant_option_" + incre_num + "')";
	var data = '<div class="form-group row">';
	data += '<div class="col-lg-5">';
	data += '<select name="select_variant[]" id="select_variant_' + incre_num + '" class="form-control variant-picker" onchange="' + onclick + '">';
	data += '<option value="">Select</option>';
	data += '</select>';
	data += '</div>';
	data += '<div class="col-lg-5">';
	data += '<select class="selectpicker form-control" id="variant_option_' + incre_num + '" name="variant_option[]" multiple data-live-search="true">';
	data += '<option>Select</option>';
	data += '</select>';
	var empt = '';
	data += '<small><a style="cursor:pointer;" data-toggle="modal" data-target="#editVariantModal" onclick="edit_variant(this,' + incre_num + ')"><i class="fa fa-edit"></i> Manage Variant.</a></small>';
	data += '</div>';
	data += '<div class="col-lg-2">';
	data += '<button type="button" class="btn btn-lg btn-gradient-0 border-dark"  onclick="del_multiple_variant(this)"> x </button>';
	data += '</div>';
	data += '</div>';
	$('.js-variant-append-div').append(data);
	load_variants('select_variant_' + incre_num);
	get_variant_options('select_variant_' + incre_num, 'variant_option_' + incre_num);
}

function del_multiple_variant(element) {
	element.parentNode.parentNode.remove();
}

// to add variant in db
function add_variant() {
	var formData = {};
	var msg = '';
	$("#variant-add-option").find("[name]").each(function (index, value) {
		var thisForm = $(this),
			fieldName = thisForm.attr("name"),
			fieldValue = thisForm.val();
		if (fieldValue == '') {
			msg += fieldName + " required <br>";
		}
	});

	formData['api_key'] = apiKey;
	formData['variant_name'] = $('#variant_name').val();

	var values = $("input[name='variant_options[]']").map(function () {
		return $(this).val();
	}).get();
	var variant_options = {};
	var valueCount = values.length;
	for (p = 0; p < valueCount; p++) {
		variant_options[p] = values[p];
	}

	formData['variants'] = variant_options;

	if (msg == '') {
		$.ajax({
			url: apiBaseUrl + 'variants/add',
			type: "POST",
			data: formData,
			success: function (response) {
				// "Parsing JSON" output 
				returnedData = JSON.parse(response);
				if (returnedData.status) {
					swal({
						title: "Success",
						text: returnedData.message,
						icon: "success",
						buttons: {
							confirm: {
								text: "Close",
								value: true,
								visible: true,
								className: "btn btn-lg btn-gradient-01",
								closeModal: true
							}
						}
					});

					variant_id = returnedData.data['variant_id'];
					variant_name = returnedData.data['variant_name'];
					var options = '<option value="' + variant_id + '">' + variant_name + '</option>';
					$('.variant-picker').append(options);
					$('#addVariantModal .close').click()
				} else {
					swal({
						title: "Error!",
						text: returnedData.message,
						icon: "error",
						buttons: {
							confirm: {
								text: "Close",
								value: true,
								visible: true,
								className: "btn btn-lg btn-gradient-01",
								closeModal: true
							}
						}
					});
					// $('#js-variant-add-form-errors').html(returnedData.message);
				}
			}
		});
	} else {
		// $('.js-variant-add-form-errors').html(msg);
		swal({
			title: "Error!",
			text: msg.split('<br>').join(', '),
			icon: "error",
			buttons: {
				confirm: {
					text: "Close",
					value: true,
					visible: true,
					className: "btn btn-lg btn-gradient-01",
					closeModal: true
				}
			}
		});
	}
}

function load_variants(select_variant) {
	var formData = {};
	formData['api_key'] = apiKey;
	$.ajax({
		url: apiBaseUrl + 'variants/retrieve',
		type: "POST",
		data: formData,
		success: function (response) {
			// "Parsing JSON" output  
			var returnedData = JSON.parse(response);
			var options = '';
			if (returnedData.status) {
				var variants = returnedData.message;
				options += '<option value="0">Select</option>'
				$.each(variants, function (index, value) {
					options += '<option value="' + value['variant_id'] + '">' + value['variant_name'] + '</option>';
				});
				if (select_variant == '') {
					console.log('do nothing');
				} else {
					$('#' + select_variant).html(options);
				}
			} else {
				console.log(returnedData);
			}
		}
	});
}

// to set options after variant selection
function get_variant_options(select_variant, variant_option) {
	var variant_id = $('#' + select_variant).val();
	if (variant_id != 0) {
		var formData = {};
		formData['api_key'] = apiKey;
		formData['variant_id'] = variant_id;
		$.ajax({
			url: apiBaseUrl + 'variants/retrieve',
			type: "POST",
			data: formData,
			success: function (response) {
				// "Parsing JSON" output 
				var returnedData = JSON.parse(response);
				var options = '';
				if (returnedData.status) {
					var variant_main = returnedData.message[0];
					var variants = returnedData.message[0]['variants'];
					$.each(variants, function (index, value) {
						var variant_val = variant_main['variant_id'] + "," + variant_main['variant_name'] + "," + index + "," + value;
						options += '<option value="' + variant_val + '">' + value + '</option>';
					});
					$('#' + variant_option).html(options);
					$(".selectpicker").selectpicker('refresh');
				} else {
					console.log(returnedData);
				}
			}
		});
	}
	$(".selectpicker").selectpicker('refresh');
}

function get_price_fields() {
	var unit_type = $('#unit_type').val();
	var fr = get_selected_variant_data();

	var i = 0;
	var arr = [];
	$.each(fr, function (key, value) {
		var arr2 = [];
		var j = 0;
		$.each(value['variant_options'], function (vKey, vValue) {
			arr2[j] = value['variant_name'] + ' : ' + vValue['variant_option'];
			arr[i] = arr2;
			j++;
		});
		i++;
	});
	var array = [].concat(...arr);
	var fieldStatus = 1;
	for (var i = 0; i < array.length; i++) {
		for (var j = i + 1; j < array.length; j++) {
			if (array[i] === array[j]) {
				fieldStatus = 0;
			}
		}
	}

	if (fieldStatus) {

		const fields = arr.reduce((acc, cu) => {
			let ret = [];
			acc.map(obj => {
				cu.map(obj_1 => {
					ret.push(obj + ',' + obj_1)
				});
			});
			return ret;
		})

		var tableData = '';
		tableData += '<div class="col-lg-12">';
		tableData += '<table class="table">';
		tableData += '<thead>';
		tableData += '<tr>';
		tableData += '<td>Variant</td>';
		if (unit_type == 'weight') {
			tableData += '<td>Measurement</td>';
			label = 'Available Weights';
		} else {
			label = 'Available Units';
		}
		tableData += '<td>Cost | SKU</td>';
		tableData += '<td>Margin | ' + label + '</td>';
		tableData += '<td>Price | Barcode</td>';
		tableData += '<td>Action</td>';
		tableData += '</tr>';
		tableData += '</thead>';
		tableData += '<tbody>';
		$.each(fields, function (index, value) {
			value = value.replace(/,/g, " | ");
			tableData += '<tr id="js-variant-cost-div-'+index+'">';
			tableData += '<td><input id="variant" type="text" name="variant[]" class="form-control" value="' + value + '" readonly></td>';
			if (unit_type == 'weight') {
				tableData += '<td><select name="measurement[]" id="measurement" class="form-control" style="width: -webkit-fill-available;"><option value="grams">Grams</option><option value="kg">Kilo Grams</option></select></td>';
			}
			tableData += '<td><input id="cost" type="text" placeholder="Cost" name="cost[]" value="" class="form-control  mb-2" onfocus="this.select();" onchange="variantCostChange(this,0)">';
			tableData += '<input id="sku" type="text" placeholder="SKU" name="sku[]" class="form-control"></td>';

			tableData += '<td><div class="input-group mb-2">';
				tableData += '<input id="margin" type="text" placeholder="Margin" name="margin[]" value="" class="form-control " onfocus="this.select();" onchange="variantCostChange(this,1)">';
				tableData += '<div class="input-group-append">';
					tableData += '<select name="margin_type[]" id="margin_type" class="form-control" onchange="marginChange(this)">';
						tableData += '<option value="percentage">%</option>';
						tableData += '<option value="currency">$</option>';
					tableData += '</select>';
				tableData += '</div>';
			tableData += '</div>';
			tableData += '<input id="quantity" type="number" placeholder="' + label + '" name="quantity[]" class="form-control"></td>';

			tableData += '<td><input id="price" type="text" placeholder="Price" name="price[]" value="" class="form-control  mb-2" onfocus="this.select();" onchange="variantCostChange(this,0)">';
			tableData += '<input id="barcode" type="text" placeholder="Barcode" name="barcode[]" class="form-control"></td>';

			tableData += '<td><button type="button" class="btn btn-lg btn-gradient-01 " onclick="del_multiple_variant(this)">x</button></td>';
			tableData += '</tr>';
		});
		tableData += '</tbody>';
		tableData += '</table>';
		tableData += '</div>';
		$('.js-variant-price-div').html(tableData);
		$('.js-variant-price-div').show();
	} else {
		// $('.js-variant-price-div').html('<p class="text-danger">You Cant Select the Same Variant Twice</p>');
		swal({
			title: "Error!",
			text: 'You Cant Select the Same Variant Twice.',
			icon: "error",
			buttons: {
				confirm: {
					text: "Close",
					value: true,
					visible: true,
					className: "btn btn-lg btn-gradient-01",
					closeModal: true
				}
			}
		});
	}
}

// to get variants ex: color-white,red 
function get_selected_variant_data() {
	// product type is variant then get variant data and allocate price fields
	var select_variant = $("select[name='select_variant[]']").map(function () {
		return $(this).val();
	}).get();

	var variant_options = $("select[name='variant_option[]']").map(function () {
		return $(this).val();
	}).get();
	var iterate = 0, i = 0;
	var final_variants = {}, final_variant_options = {}, fr = {}, dummy = {};
	$.each(select_variant, function (index, value) {
		$.each(variant_options, function (varIndex, varValue) {
			var options = varValue.split(',');
			final_variants['variant_id'] = options[0];
			final_variants['variant_name'] = options[1];
			final_variant_options['variant_option_id'] = options[2];
			final_variant_options['variant_option'] = options[3];

			if (value == options[0]) {
				fr[iterate] = final_variants;
				dummy[i] = final_variant_options;
				fr[iterate]['variant_options'] = dummy;
				i++;
			}
			final_variants = {}; final_variant_options = {};
		});
		dummy = {};
		iterate++;
		i = 0;
	});
	return fr;
}

function getFields(fr, j, fields) {
	var k = 0;
	if (typeof (fr[j]) != "undefined" && fr[j] !== null) {
		$.each(fr[j]['variant_options'], function (innerIndex, innerValue) {
			fields[k] = fields + ", " + innerValue['variant_option'];
			j = j + 1;
			fields[k] = getFields(fr, j, fields);
			k++;
		});
	}
	return fields;
}

// to add variant option for edit modal row in design
function add_edit_variant_option(element, className) {
	// $(element).attr('onclick','del_variant_option(this)');
	// $(element).html('<i class="fa fa-trash mr-0"></i>');
	var data = '<div class="row mb-1">';
	data += '<div class="col-lg-8">';
	data += '<input id="variant_options" type="text" placeholder="Ex: Red" name="variant_options[]" value="" class="form-control h-100">';
	data += '</div>';
	data += '<div class="col-lg-2">';
	var click = "del_variant_option(this)";
	data += '<span class="btn btn-lg btn-danger" onclick="' + click + '"><i class="fa fa-trash mr-0"></i></span>';
	data += '</div>';
	data += '</div>';
	$('.' + className).append(data);
}

function edit_variant(ele, id) {
	if (id != '') {
		id = "_" + id;
	}
	$('#edit-variant-select').val('select_variant' + id);
	$('#edit-variant-option').val('variant_option' + id);
	var variant_id = $('#select_variant' + id).val();
	var formData = {};
	formData['api_key'] = apiKey;
	formData['variant_id'] = variant_id;
	$.ajax({
		url: apiBaseUrl + 'variants/retrieve',
		type: "POST",
		data: formData,
		async: false,
		success: function (response) {
			// "Parsing JSON" output 
			returnedData = JSON.parse(response);
			if (returnedData.status) {
				var data = returnedData.message[0];
				var variantData = '';

				$('#edit_variant_name').val(data['variant_name']);
				$('#edit-variant-id').val(data['variant_id']);

				variantData += '<div class="row">';
				variantData += ' <div class="col-lg-2">';
				var click = "add_edit_variant_option(this,'js-variant-edit-options')";
				variantData += '<span class="btn btn-lg btn-gradient-01 mb-2" onclick="' + click + '">+ Add Option</span>';
				variantData += ' </div>';
				variantData += '</div>';

				$.each(data['variants'], function (key, value) {
					variantData += '<div class="row mb-1">';
					variantData += '<div class="col-lg-8">';
					variantData += '<input id="variant_options" type="text" placeholder="Ex: Red" name="variant_options[]" value="' + value + '" class="form-control h-100">';
					variantData += '</div>';
					variantData += '<div class="col-lg-2">';
					var click = "del_variant_option(this)";
					variantData += '<span class="btn btn-lg btn-danger" onclick="' + click + '"><i class="fa fa-trash mr-0"></i></span>';
					variantData += '</div>';
					variantData += '</div>';
				});

				$('.js-variant-edit-options').html(variantData);
			} else {

				// $('#js-variant-edit-form-errors').html(returnedData.message);
				swal({
					title: "Error!",
					text: returnedData.message,
					icon: "error",
					buttons: {
						confirm: {
							text: "Close",
							value: true,
							visible: true,
							className: "btn btn-lg btn-gradient-01",
							closeModal: true
						}
					}
				});
			}
		}
	});
}

function modify_variant() {
	var formData = {};
	var msg = '';
	$("#variant-edit-option").find("[name]").each(function (index, value) {
		var thisForm = $(this),
			fieldName = thisForm.attr("name"),
			fieldValue = thisForm.val();
		if (fieldValue == '') {
			msg += fieldName + " required <br>";
		}
	});

	formData['api_key'] = apiKey;
	formData['variant_name'] = $('#edit_variant_name').val();
	formData['variant_id'] = $('#edit-variant-id').val();
	var edit_variant_select = $('#edit-variant-select').val();
	var edit_variant_option = $('#edit-variant-option').val();
	var values = $(".js-variant-edit-options input[name='variant_options[]']").map(function () {
		return $(this).val();
	}).get();
	var variant_options = {};
	var valueCount = values.length;
	for (p = 0; p < valueCount; p++) {
		variant_options[p] = values[p];
	}

	formData['variants'] = variant_options;

	if (msg == '') {
		$.ajax({
			url: apiBaseUrl + 'variants/modify',
			type: "POST",
			data: formData,
			success: function (response) {
				// "Parsing JSON" output 
				returnedData = JSON.parse(response);
				if (returnedData.status) {
					swal({
						title: "Success",
						text: returnedData.message,
						icon: "success",
						buttons: {
							confirm: {
								text: "Close",
								value: true,
								visible: true,
								className: "btn btn-lg btn-gradient-01",
								closeModal: true
							}
						}
					}).then((value) => {
						get_variant_options(edit_variant_select, edit_variant_option);
					});
					$('#editVariantModal .close').click()
				} else {
					swal({
						title: "Error!",
						text: returnedData.message,
						icon: "error",
						buttons: {
							confirm: {
								text: "Close",
								value: true,
								visible: true,
								className: "btn btn-lg btn-gradient-01",
								closeModal: true
							}
						}
					});
					// $('#js-variant-edit-form-errors').html(returnedData.message);
					swal({
						title: "Error!",
						text: returnedData.message,
						icon: "error",
						buttons: {
							confirm: {
								text: "Close",
								value: true,
								visible: true,
								className: "btn btn-lg btn-gradient-01",
								closeModal: true
							}
						}
					});
				}
			}
		});
	} else {
		// $('.js-variant-edit-form-errors').html(msg);
		swal({
			title: "Error!",
			text: msg.split('<br>').join(', '),
			icon: "error",
			buttons: {
				confirm: {
					text: "Close",
					value: true,
					visible: true,
					className: "btn btn-lg btn-gradient-01",
					closeModal: true
				}
			}
		});
	}
}

function delete_variant() {
	var formData = {};
	var msg = '';

	formData['api_key'] = apiKey;
	formData['variant_id'] = $('#edit-variant-id').val();
	if (msg == '') {
		$.ajax({
			url: apiBaseUrl + 'variants/delete',
			type: "POST",
			data: formData,
			success: function (response) {
				// "Parsing JSON" output 
				returnedData = JSON.parse(response);
				if (returnedData.status) {
					swal({
						title: "Success",
						text: returnedData.message,
						icon: "success",
						buttons: {
							confirm: {
								text: "Close",
								value: true,
								visible: true,
								className: "btn btn-lg btn-gradient-01",
								closeModal: true
							}
						}
					}).then((value) => {
						get_variant_options(edit_variant_select, edit_variant_option);
					});
					$('#editVariantModal .close').click()
				} else {
					swal({
						title: "Error!",
						text: returnedData.message,
						icon: "error",
						buttons: {
							confirm: {
								text: "Close",
								value: true,
								visible: true,
								className: "btn btn-lg btn-gradient-01",
								closeModal: true
							}
						}
					});
					// $('#js-variant-edit-form-errors').html(returnedData.message);
					swal({
						title: "Error!",
						text: returnedData.message,
						icon: "error",
						buttons: {
							confirm: {
								text: "Close",
								value: true,
								visible: true,
								className: "btn btn-lg btn-gradient-01",
								closeModal: true
							}
						}
					});
				}
			}
		});
	} else {
		// $('.js-variant-edit-form-errors').html(msg);
		swal({
			title: "Error!",
			text: msg.split('<br>').join(', '),
			icon: "error",
			buttons: {
				confirm: {
					text: "Close",
					value: true,
					visible: true,
					className: "btn btn-lg btn-gradient-01",
					closeModal: true
				}
			}
		});
	}
}

// function for selecting type
function select_type() {
	var type = $('#unit_type').val();
	if (type == 'unit') {
		$('#product_type').val('non-variant');
		$('.js-variant-div').hide();
		$('.js-variant-price-div').hide();
		$('#js-non-variant-weight-div').hide();
		$('#js-non-variant-dimentions-div').hide();
		$('#js-non-variant-unit-div').show();
	}
	else if (type == "weight") {
		$('#product_type').val('non-variant');
		$('.js-variant-div').hide();
		$('.js-variant-price-div').hide();
		$('#js-non-variant-unit-div').hide();
		$('#js-non-variant-dimentions-div').hide();
		$('#js-non-variant-weight-div').show();
	} else if (type == "dimensions") {
		$('#product_type').val('non-variant');
		$('.js-variant-div').hide();
		$('.js-variant-price-div').hide();
		$('#js-non-variant-unit-div').hide();
		$('#js-non-variant-weight-div').hide();
		$('#js-non-variant-dimentions-div').show();
	} else {
		alert("nothing selected");
	}
}

function get_display_plugins(display_category) {
	var formData = {};
	formData['api_key'] = apiKey;
	formData['display_category'] = display_category;
	$.ajax({
		url: apiBaseUrl + 'plugin_store/retrieve_display_plugins',
		type: "POST",
		data: formData,
		success: function (response) {
			// "Parsing JSON" output  
			var returnedData = JSON.parse(response);
			if (returnedData.status) {
				var plugins = returnedData.message;
				$.each(plugins, function (key, plugin) {
					var app_name = plugin['app_name'];
					var file = '';

					app_name = app_name.toLowerCase();
					app_name = app_name.replace(' ', '_');
					var display_on = plugin['display_on'];
					$.each(display_on, function (dKey, dValue) {
						if (dValue['page'] == display_category) {
							file = dValue['file'];
						}
					});
					var p_id = $('#product_id').val();
					var iframeSourceLink = pluginBaseurl + app_name + '/' + file + '?api_key=' + apiKey + '&api_base_url=' + apiBaseUrl + '&extra_data=online&id=' + p_id;
					$('.custom-plugins').html('<iframe id="iframe" src="' + iframeSourceLink + '" frameBorder="0" height="500px" width="100%" ></iframe>');
				});
			} else {
				console.log(returnedData);
			}
		}
	});
}
$('#profile-tab').click(function () {
	var p_id = $('#product_id').val();
	if (p_id == undefined || p_id == '') {
		$('#profile').hide();
		alert('Please Add Product and Continue...!');
	}
});
function get_tree_categories() {
	//header categories menu data
	formData = {};
	formData['api_key'] = localStorage.getItem('api_key');
	$.ajax({
		url: apiBaseUrl + 'categories/retrieve',
		type: "POST",
		data: formData,
		async: false,
		success: function (response) {
			var main_category = '';
			var search_category = '';
			var mobile_category = '', iterate = 0;
			// "Parsing JSON" output 
			returnedData = JSON.parse(response);
			if (returnedData.status) {

				var categories = returnedData.message
				categories.forEach(function (cat) {
					if (cat['category_name'] != '') {
						var subLength = cat['sub_categories'].length;
						if (subLength > 0) {
							var icon = '<i class="fa fa-plus"></i> ';
						} else {
							var icon = ' ';
						}
						main_category += '<li>' + icon + ' <div class="styled-checkbox" style="display:inline-block"> <input id="' + cat['category_id'] + '" data-id="' + cat['category_id'] + '" type="checkbox"><label for="' + cat['category_id'] + '"> ' + cat['category_name'] + '</label></div>';
						if (cat['sub_categories'].length > 0) {
							main_category += '<ul>';
							main_category += get_tree_sub_categories(cat['sub_categories']);
							main_category += '</ul>';
						}

						main_category += '</li>';
						iterate++;
					}//category name empty if close
				});//categories forEach close
				$('.js-categories-list').append(main_category);
			} else {
				alert(returnedData.message);
			}
		}//sucess close
	});//ajax close
	//to get sub categories
}
function get_tree_sub_categories(data) {
	var sub_cat_len = data.length;
	var sub_category = '', imageSubCat = '', iterate = 0, imageCount = 0;
	if (sub_cat_len > 0) {
		var catArr = [];
		var icon2 = '';
		var last = '';
		data.forEach(function (sub_cat) {
			// sub_category += '<ul>';
			var lenght2 = sub_cat['sub_categories'].length;
			var catName = (sub_cat['category_name'].slice(0, 15)) + '..';
			if (lenght2 > 0) {
				icon2 = '<i class="fa fa-plus"></i> ';
				last = '';
			} else {
				icon2 = '';
				last = 'class="hummingbirdNoParent"';
			}
			sub_category += '<li>' + icon2 + ' <div class="styled-checkbox" style="display:inline-block"> <input id="' + sub_cat['category_id'] + '" data-id="' + sub_cat['category_id'] + '" type="checkbox" value="' + sub_cat['category_id'] + '" ' + last + '><label for="' + sub_cat['category_id'] + '">' + catName + '</label></div>';
			if (lenght2 > 0) {
				sub_category += '<ul>';
				sub_category += get_tree_sub_categories(sub_cat['sub_categories']);
				sub_category += '</ul>';
			}
			sub_category += '</li>';
			// sub_category += '</ul>';
		});//sub categories forEach close

	}
	return sub_category;
}
// functio for get extra options data
function get_extra_options_data() {
	var formData = {};
	formData['api_key'] = apiKey;
	$.ajax({
		url: apiBaseUrl + 'extra_options/retrieve',
		type: "POST",
		data: formData,
		success: function (response) {
			returnedData = JSON.parse(response);
			console.log(returnedData);
			var options = '';
			$.each(returnedData.message, function (index, value) {
				options += '<option value="' + value['extra_option_id'] + '">' + value['extra_option'] + ' - $' + value['price'] + '</option>';
			});
			$('#extra_option').html(options);
			$(".selectpicker").selectpicker('refresh');
		}
	});
}
//function for add extra option
function add_extra_option() {
	var formData = {};
	var msg = '';
	$("#extra-add-option").find("[name]").each(function (index, value) {
		var thisForm = $(this),
			fieldName = thisForm.attr("name"),
			fieldValue = thisForm.val();
		if (fieldValue == '') {
			msg += fieldName + " required <br>";
		}
	});

	formData['api_key'] = apiKey;

	var options = $("input[name='modal_extra_option[]']").map(function () {
		return $(this).val();
	}).get();
	var price = $("input[name='modal_extra_price[]']").map(function () {
		return $(this).val();
	}).get();
	var variant_options_data = {};
	var valueCount = options.length;
	for (p = 0; p < valueCount; p++) {
		var optionsData = {};
		optionsData['extra_option'] = options[p];
		optionsData['extra_price'] = price[p];
		variant_options_data[p] = optionsData;
	}

	formData['extra_option_data'] = variant_options_data;
	console.log(formData);
	if (msg == '') {
		$.ajax({
			url: apiBaseUrl + 'extra_options/add',
			type: "POST",
			data: formData,
			success: function (response) {
				// "Parsing JSON" output 
				returnedData = JSON.parse(response);
				console.log(returnedData);
				if (returnedData.status) {
					swal({
						title: "Success",
						text: returnedData.message,
						icon: "success",
						buttons: {
							confirm: {
								text: "Close",
								value: true,
								visible: true,
								className: "btn btn-lg btn-gradient-01",
								closeModal: true
							}
						}
					}).then((value) => {
						get_extra_options_data();
					});
					$('#addextraModal .close').click()
				} else {
					swal({
						title: "Error!",
						text: returnedData.message,
						icon: "error",
						buttons: {
							confirm: {
								text: "Close",
								value: true,
								visible: true,
								className: "btn btn-lg btn-gradient-01",
								closeModal: true
							}
						}
					});
				}
			}
		});
	} else {
		swal({
			title: "Error!",
			text: msg.split('<br>').join(', '),
			icon: "error",
			buttons: {
				confirm: {
					text: "Close",
					value: true,
					visible: true,
					className: "btn btn-lg btn-gradient-01",
					closeModal: true
				}
			}
		});
	}
}
// function for manage extra option
function edit_extraOption() {
	var formData = {};
	formData['api_key'] = apiKey;
	$.ajax({
		url: apiBaseUrl + 'extra_options/retrieve',
		type: "POST",
		data: formData,
		async: false,
		success: function (response) {
			// "Parsing JSON" output 
			returnedData = JSON.parse(response);
			if (returnedData.status) {
				var data = returnedData.message;
				var variantData = '';
				variantData += '<div class="row">';
				variantData += ' <div class="col-lg-2">';
				var click = "add_edit_variant_option(this,'js-variant-edit-options')";
				variantData += '<span class="btn btn-lg btn-gradient-01 mb-2" onclick="' + click + '">+ Add Option</span>';
				variantData += ' </div>';
				variantData += '</div>';

				$.each(data, function (key, value) {
					variantData += '<div class="row mb-1">';
					variantData += '<div class="col-lg-4 mb-2">';
					variantData += '<input id="edit_extra_option-' + key + '" type="text" placeholder="Ex: Red" name="edit_extra_option" value="' + value['extra_option'] + '" class="form-control">';
					variantData += '</div>';
					variantData += '<div class="col-lg-4 mb-2">';
					variantData += '<input id="edit_extra_price-' + key + '" type="text" placeholder="Ex: Red" name="edit_extra_price" value="' + value['price'] + '" class="form-control">';
					variantData += '</div>';
					variantData += '<div class="col-lg-2 mb-2">';
					var deleteclick = "del_extra_option(this," + value['extra_option_id'] + ")";
					variantData += '<span class="btn btn-lg btn-danger" onclick="' + deleteclick + '"><i class="fa fa-trash mr-0"></i></span>';
					variantData += '</div>';
					variantData += '<div class="col-lg-2 mb-2">';
					var editeclick = "edit_extra_option(this," + value['extra_option_id'] + ")";
					variantData += '<span class="btn btn-lg btn-success" onclick="' + editeclick + '"><i class="fa fa-pencil mr-0"></i></span>';
					variantData += '</div>';
					variantData += '</div>';
				});

				$('.js-extra-edit-options').html(variantData);
			} else {

				// $('#js-variant-edit-form-errors').html(returnedData.message);
				swal({
					title: "Error!",
					text: returnedData.message,
					icon: "error",
					buttons: {
						confirm: {
							text: "Close",
							value: true,
							visible: true,
							className: "btn btn-lg btn-gradient-01",
							closeModal: true
						}
					}
				});
			}
		}
	});
}
// function for delete extra option 
function del_extra_option(row, extra_optin_id) {
	var formData = {};
	formData['api_key'] = apiKey;
	formData['extra_option_id'] = extra_optin_id;
	$.ajax({
		url: apiBaseUrl + 'extra_options/retrieve',
		type: "POST",
		data: formData,
		async: false,
		success: function (response) {
			var data = JSON.parse(response);
			if (data.status) {
				$(row).parent.parent.remove();
			} else {
				swal({
					title: "Error!",
					text: data.message,
					icon: "error",
					buttons: {
						confirm: {
							text: "Close",
							value: true,
							visible: true,
							className: "btn btn-lg btn-gradient-01",
							closeModal: true
						}
					}
				});
			}
		}
	});

}
// function for add extrapt option dynamic element add
function add_extra_option_modal() {
	var data = '<div class="row mb-2">';
	data += '<div class="col-lg-5">';
	data += '<input id="model_extra_option" type="text" placeholder="Ex:  1 Egg" name="modal_extra_option[]" value="" class="form-control h-100">';
	data += '</div>';
	data += '<div class="col-lg-5">';
	data += '<input id="extra_price" type="number" placeholder="Ex:  $5" name="modal_extra_price[]" value="" class="form-control h-100">';
	data += '</div>';
	data += '<div class="col-lg-2">';
	data += '<span class="btn btn-lg btn-danger" onclick="del_extra_option_modal(this)"><i class="fa fa-trash mr-0"></i></span>';
	data += '</div>';
	data += '</div>';
	$('.js-extra-add-options_modal').append(data);
}
// function for delete extra option row
function del_extra_option_modal(d) {
	d.parentNode.parentNode.remove();
}