<?php
include('settings.php');

 if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
$actionfunction = $_REQUEST['actionfunction'];
  
   call_user_func($actionfunction,$_REQUEST,$con,$limit,$adjacent);
}
function showData($data,$con,$limit,$adjacent){
  $page = $data['page'];
   if($page==1){
   $start = 0;  
  }
  else{
  $start = ($page-1)*$limit;
  }
  $sql = "select * from products order by product_id asc";
  $rows  = $con->query($sql);
  $rows  = $rows->num_rows;
  
  $sql = "select * from products order by product_id asc limit $start,$limit";
  
  $data = $con->query($sql);
  $str='<table><tr class="head"><td>Product ID</td><td>Product Name</td><td>Product Code</td><td>Quick Overview</td><td>Type</td><td>Unit of Measurement</td><td>Status</td><td>Ordinal</td><td>Last Change</td></tr>';
  if($data->num_rows>0){
   while( $row = $data->fetch_array(MYSQLI_ASSOC)){
      $str.="<tr><td>".$row['product_id']."</td><td>".$row['name']."</td><td>".$row['code']."</td><td>".$row['quick_overview']."</td><td>".$row['type']."</td><td>".$row['unit_of_measurement']."</td><td>".$row['status']."</td><td>".$row['ordinal']."</td><td>".$row['last_change']."</td></tr>";
   }
   }else{
    $str .= "<td colspan='5'>No Data Available</td>";
   }
   $str.='</table>';
   
echo $str; 
hac($limit,$adjacent,$rows,$page);  
}
function hac($limit,$adjacents,$rows,$page){	
	$hac='';
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$prev_='';
	$first='';
	$lastpage = ceil($rows/$limit);	
	$next_='';
	$last='';
	if($lastpage > 1)
	{	
		
		//previous button
		if ($page > 1) 
			$prev_.= "<a class='page-numbers' href=\"?page=$prev\">previous</a>";
		else{
			//$hac.= "<span class=\"disabled\">previous</span>";	
			}
		
		//pages	
		if ($lastpage < 5 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
		$first='';
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$hac.= "<span class=\"current\">$counter</span>";
				else
					$hac.= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";					
			}
			$last='';
		}
		elseif($lastpage > 3 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			$first='';
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$hac.= "<span class=\"current\">$counter</span>";
					else
						$hac.= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";					
				}
			$last.= "<a class='page-numbers' href=\"?page=$lastpage\">Last</a>";			
			}
			
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
		       $first.= "<a class='page-numbers' href=\"?page=1\">First</a>";	
			for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$hac.= "<span class=\"current\">$counter</span>";
					else
						$hac.= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";					
				}
				$last.= "<a class='page-numbers' href=\"?page=$lastpage\">Last</a>";			
			}
			//close to end; only hide early pages
			else
			{
			    $first.= "<a class='page-numbers' href=\"?page=1\">First</a>";	
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$hac.= "<span class=\"current\">$counter</span>";
					else
						$hac.= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";					
				}
				$last='';
			}
            
			}
		if ($page < $counter - 1) 
			$next_.= "<a class='page-numbers' href=\"?page=$next\">next</a>";
		else{
			//$hac.= "<span class=\"disabled\">next</span>";
			}
		$hac = "<div class=\"hac\">".$first.$prev_.$hac.$next_.$last;
		//next button
		
		$hac.= "</div>\n";		
	}

	echo $hac;  
}
?>