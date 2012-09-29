function showCart(){
    $.ajax({
        url:baseUrl()+'/cart/show',
        dataType:'html',
        success:function(msg){
            $('div#cart-detail').html(msg);
            return false;
        }
    });

}
$(document).ready(function(){
	showCart();
});

function onAddToCart(pro_id,qty){
    $.ajax({
        url:baseUrl()+'/cart/add/product_id/'+pro_id+'/qty/'
    });
	showCart();
    
}

function onDelProCart(pro_id){
    if(confirm('are you sure?')){
         $.ajax({
            url:baseUrl()+'/cart/delete/product_id/'+pro_id
        });
    	showCart();  
    }
   
}