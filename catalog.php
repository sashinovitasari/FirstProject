<!DOCTYPE html>
<html>
	<head>
    <title> SaleProject | Add Product </title>
    <link rel="stylesheet" type="text/css" href="saleproject.css" />
	<link href="https://fonts.googleapis.com/css?family=Varela+Round:" rel="stylesheet">
    </head>	
    <body>
    	<!-- Webpage Title -->
    	<h1 class="title1"> Sale<span class="title2">Project </span></h1>
		<!-- Menu------------>
    	<div class="containnav">
    		<!--user and logout button-->
    		<div class="usergreet">
				Hi, <?php echo $_GET["username"]?> 
			</div>
    		<div class="logout_button">logout</div> <br><br>
    		<!--Nav Bar-->
	    		<button class="navbar">Catalog</button>
				<button class="navbar">Your Products</button>
				<button class="navbar">Add Product</button>
				<button class="navbar">Sales</button>
				<button class="navbar">Purchases</button>
		<br><br>
		<h3 class="title3">What are you going to buy today?</h3>
	<!--Search Form------------------>
		<div class="containnav">
			<form action="retrieveCatalog.php" method="post" class = "user">
				<script>
					function checkSearch(){
						var x = document.getElementById("search").value;
						if (x==null || x==""){
							document.getElementById("errMess").innerHTML = "*Keyword field must be filled out";
							return false;
						}else return true;
					}
				</script>
				<table style="width:100%">
					<td style="width:90%"><input type="text" id="search" name="keyword" class="searchBar" placeholder="Search catalog..."/></td>
					<td><button type="submit" class="searchButton" name="searchButtom" onclick="return checkSearch()">GO</button></td>
					<br>
					</td>
				</table>
				<span class="errMess" id="errMess"></span><br>
				<br>
				<table>
					<td style="width:30%" valign="top"> by</td>
					<td style="vertical-align :top">
						<form action="">
							<input type="radio" name="category" value="product"> product<br>
							<input type="radio" name="category" value="store"> store <br>
						</form>
					</td>
				</table>
			</form>	
	<!---Datalist---------------->
			<br>
			<br>
			<?php
				session_start();
				if (isset($_SESSION["user"])){
					$user 	= $_SESSION["user"];
					$pN 	= $_SESSION["pN"];
					$date	= $_SESSION["date"];
					$desc	= $_SESSION["desc"];
					$price	= $_SESSION["price"];
					$pict	= $_SESSION["pict"];
					$like 	= $_SESSION["like"];
					$purch 	= $_SESSION["purch"];
					$id_pro	= $_SESSION["idp"];
					$is_Like=$_SESSION["isLike"];
					if (sizeof($user)>0) $found = true;
						else $found = false;
				}
				else
					$found = false;
			
				if ($found==true){
					for ($i=0; $i<sizeof($user); $i++){?>
						<div class = "user"><b><?php echo $user[$i]?></b><br>
						<div style="margin-bottom:10px"><?php echo $date[$i]?></div>
						<hr style="margin-left: 5px">
						<table class="tableShow">
							<td style="width:25% ">
								<?php echo '<img class="displayImg" src="data:image/jpeg;base64,'.base64_encode( $pict[$i] ).'"/>'; ?>
							</td>
							<td style="width:49%" valign="top">
								<div style="font-size: 18px"><b><?php echo $pN[$i]?></b><br>
								IDR <?php echo number_format($price[$i],0,",",".")."</div>".$desc[$i]?>
							</td>
							<td valign="top">
								<br><div style="margin-left:5px">
								<span id='l<?php echo $i ?>'> <?php echo $like[$i]?> </span> likes<br>
								<?php echo $purch[$i]." purchases<br>" ?>
								</div>
								<br>
								<div>
									
									<script>
										function upLike(i,j,k){
											var ajaxReq = new XMLHttpRequest();
											ajaxReq.onreadystatechange = function(){
											if (ajaxReq.readyState==4){
																							var ajaxDisplay = document.getElementById(k);
												ajaxDisplay.innerHTML = ajaxReq.responseText;
												
												var likeSum = document.getElementById('l'+k);
													var countLike = likeSum.innerHTML*1;
													if (j==1) countLike -= 1;
													else countLike += 1;
													likeSum.innerHTML = countLike*1;
											}
											}
											
											var val 	= i + "";//document.getElementById(i).value;
											var ilike 	= j + "";//"<?php echo $is_Like[$i]; ?>";
											var idx		= k	+ "";
											
											var queryString="?val="+val+"&ilike="+ilike+"&idx="+idx;//+"&uname="+uname;
											ajaxReq.open("GET","ajaxTry.php"+ queryString,true);
											ajaxReq.send(null);
											
											/*var ajaxReq = new XMLHttpRequest();
											ajaxReq.onreadystatechange = function(){
											if (ajaxReq.readyState==4){
													var ajaxDisplay = document.getElementById(k);
													ajaxDisplay.innerHTML = ajaxReq.responseText;
												
													var likeSum = document.getElementById('l'+k);
													var countLike = likeSum.innerHTML*1;
													if (j==1) countLike -= 1;
													else countLike += 1;
													likeSum.innerHTML = countLike*1;
												}
											}
											alert("hi");
											var val 	= i + "";//document.getElementById(i).value;
											var ilike 	= j + "";//"<?php echo $is_Like[$i]; ?>";
											var idx		= k	+ "";
											
											var queryString="?val="+val+"&ilike="+ilike+"&idx="+idx;//+"&uname="+uname;
											ajaxReq.open("GET","ajaxTry.php"+ queryString,true);
											ajaxReq.send(null);*/
										}
									</script>
									<br><br>								
									
									<span id='<?php echo $i?>'>
										<?php if ($is_Like[$i]==1){?>
											<input type = 'button'  class="likeButton" onclick = 'upLike(<?php echo $id_pro[$i];?>,<?php echo $is_Like[$i];?>, <?php echo $i;?> )' id='a<?php echo $id_pro[$i]?>' value = 'LIKED'/>
										<?php }else{ ?>
											<input type = 'button'  class="unlikeButton" onclick = 'upLike(<?php echo $id_pro[$i];?>,<?php echo $is_Like[$i];?>, <?php echo $i;?>)' id='a<?php echo $id_pro[$i]?>' value = 'LIKE'/>
										<?php } ?>
									</span>
									
									<form action="retrievePurchase.php" method="post" class = "user">
										<button type="submit" class="buyButton" name="buyButton" value="<?php echo $id_pro[$i]?>"><b>Buy<b></button>
									</form>
								</div>
							</td>
						</table>
						<br>
						<hr style="margin-left: 5px">
						<br><br>
				<?php }
			}
			else echo "<br><br><h1 style=\"text-align:center\">not found</h1>";	?>
		<br>
		
	<!--------------------------->
		<p class="clear"></p>
		</div>
	</body>
</html>
