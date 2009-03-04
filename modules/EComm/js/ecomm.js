function expandTree(id, action){
	//First, change the text of the hyper link from (+) to (-)
	//Also, change the URL from expandTree to collapseTree
	document.getElementById('group_' + id).innerHTML="(-)";
	document.getElementById('group_' + id).href="javascript:collapseTree(" + id + ", '" + action + "')";
	
	var subGroupsDiv = $('children_' + id); 
	new Ajax.Request('/Store/Tree/' + id + '&action=' + action, {
		method: 'post',
		parameters: { },
		onComplete: function(transport) {
			subGroupsDiv.update(transport.responseText);
		}
	});
}

function collapseTree(id, action){
	//First, change the text of the hyper link from (-) to (+)
	//Also, change the URL from collapseTree to expandTree
	//And hide the children of this group
	document.getElementById('group_' + id).innerHTML="(+)";
	document.getElementById('group_' + id).href="javascript:expandTree(" + id + ", '" + action + "')";
	var subGroupsDiv = $('children_' + id); 
	subGroupsDiv.update('');
}

function displayProducts(id, action){
	if (action == "Category")
		expandTree(id, action);
	var productsDiv = $('TreeProducts'); 
	st = "/Store/" + action + "/" + id;
	new Ajax.Request(st, {
		method: 'post',
		parameters: { },
		onComplete: function(transport) {
			productsDiv.update(transport.responseText);
		}
	});
}

function removeProductFromCart(id){
	if (confirm('Are you sure you want to remove this product from your shopping cart?')){
		new Ajax.Request('/Store/Cart/&action=Delete&id=' + id, {
			method: 'get',
			parameters: { },
			onComplete: function(transport) {
				if (transport.responseText == "True"){//If the requests returns "True", it means it was deleted from the database
					var row = document.getElementById("row_" + id);
					document.getElementById('cartItems').deleteRow(row.rowIndex);
					getCartInfo();
				}
				else
					alert(transport.responseText);
			}
		});
	}	
}

function getCartInfo(){
	//There is no need to refresh the cart details unless the user is on the cart or checkout pages
	if(document.getElementById('cartDetailsSubTotal') == null){
		return;
	}
	new Ajax.Request('/Store/Cart/&action=Details', {
		method: 'get',
		parameters: { },
		onComplete: function(transport) {
			var st = transport.responseText;//The response text will be: subTotal,tax,shipping,total
			myArray = st.split(/ /);
			document.getElementById("cartDetailsSubTotal").innerHTML = myArray[0];
			document.getElementById("cartDetailsTax").innerHTML = myArray[1];
			document.getElementById("cartDetailsShipping").innerHTML = myArray[2];
			document.getElementById("cartDetailsTotal").innerHTML = myArray[3];
			//There is no need to change the payment form. It is refreshed right before payment
		}
	});
}

function addressEdit( element) {
	var section = element;
	var element = $(element);
	return new Ajax.Request('/Store/Cart/&action=Address', {
		method: 'post',
		parameters: { 'adr_type': section},
		onSuccess: function(transport) {
			element.update(transport.responseText);
			var form = element.down('form');
			$(form).observe('submit', function(event){
				form.request({
					parameters: { 'adr_type': element.identify() },
					onComplete: function(transport) {
						element.update(transport.responseText);
						if (section != 'phone_number')//No need to refresh the cart details if what changed is the phone number
							getCartInfo();
					}
				});
				Event.stop(event);
			});
		}
	});
}

function changeShippingClass(){
	var details = $('shippingClassDetails');
	shippingClass = document.getElementById("shipping_option").options[document.getElementById("shipping_option").selectedIndex].value;
	new Ajax.Request('/Store/Cart/&action=ShippingChange', {
		method: 'post',
		parameters: { 'shippingClass': shippingClass},
		onComplete: function(transport) {
			details.update(transport.responseText);
			getCartInfo();
		}
	});
}

function changePaymentClass(submitForm){
	//If submitForm is defined, submit the payment form after refreshing it
	var details = $('paymentClassDetails');
	var form = $('payment_form');
	paymentClass = document.getElementById("payment_option").options[document.getElementById("payment_option").selectedIndex].value;
	new Ajax.Request('/Store/Cart/&action=PaymentChange', {
		method: 'post',
		parameters: { 'paymentClass': paymentClass},
		onComplete: function(transport) {
			myArray = transport.responseText.split(/\n/);
			details.update(myArray[0]);
			form.update(myArray[1]);
			if (submitForm == true)
				document.payment_form.submit();
		}
	});
}

function checkBeforePayment(){
	var deliveryInstructions = document.getElementById('delivery_direction_textarea').value;
	//Make sure all the information is consistent before proceeding to payment
	new Ajax.Request('/Store/Cart/&action=CheckBeforePayment', {
		method: 'post',
		parameters: { 'deliveryInstructions': deliveryInstructions},
		onComplete: function(transport) {
			st = transport.responseText;
			if (st == "0")//Generate the payment form to include the transaction ID in it and then submit the form
				changePaymentClass(true);
			else
				alert(st);
		}
	});
	return false;
}

var requestOrderDetails = function(element) {
	return $(element).request({
		onSuccess: function(transport) {
			showThickBox(transport);
		}
	});
}

function showThickBox(transport) {
	facebox.loading();
	facebox.reveal(transport.responseText);
	new Effect.Appear($('facebox'), {duration: 0.2, fps: 100});
	
	if (form = $('facebox').down('form')) {
		Event.observe(form, 'submit', function(event) {
	  		formSubmit(form);
	  		Event.stop(event);
	 	});
 	}
}