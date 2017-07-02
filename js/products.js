
 $(function(){
 $.ajax({
	     url:"dbproducts.php",
                  type:"POST",
                  data:"actionfunction=showData&page=1",
        cache: false,
        success: function(response){
		   
		  $('#hac').html(response);
		 
		}
		
	   });
    $('#hac').on('click','.page-numbers',function(){
       $page = $(this).attr('href');
	   $pageind = $page.indexOf('page=');
	   $page = $page.substring(($pageind+5));
       
	   $.ajax({
	     url:"dbproducts.php",
                  type:"POST",
                  data:"actionfunction=showData&page="+$page,
        cache: false,
        success: function(response){
		   
		  $('#hac').html(response);
		 
		}
		
	   });
	return false;
	});
	
});
	   
