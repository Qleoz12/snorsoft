<script type="text/javascript">
$(document).ready(function() {
	$("#results" ).load( "fetch_pages.php"); //load initial records
	
	//executes code below when user click on pagination links
	$("#results").on( "click", ".pagination a", function (e){
		e.preventDefault();
		$(".loading-div").show(); //show loading element
		var page = $(this).attr("data-page"); //get page number from link
		$("#results").load("fetch_pages.php",{"page":page}, function(){ //get content from PHP page
			$(".loading-div").hide(); //once done, hide loading element
		});
		
	});
});
</script>
<style>
body,td,th {
	font-family: Georgia, "Times New Roman", Times, serif;
	color: #333;
}
.contents{
	margin: 20px;
	padding: 20px;
	list-style: none;
	background: #F9F9F9;
	border: 1px solid #ddd;
	border-radius: 5px;
}
.contents li{
    margin-bottom: 10px;
}
.loading-div{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0, 0, 0, 0.56);
	z-index: 999;
	display:none;
}
.loading-div img {
	margin-top: 20%;
	margin-left: 50%;
}

/* Pagination style */
.pagination{margin:0;padding:0;}
.pagination li{
	display: inline;
	padding: 6px 10px 6px 10px;
	border: 1px solid #ddd;
	margin-right: -1px;
	font: 15px/20px Arial, Helvetica, sans-serif;
	background: #FFFFFF;
	box-shadow: inset 1px 1px 5px #F4F4F4;
}
.pagination li a{
    text-decoration:none;
    color: rgb(89, 141, 235);
}
.pagination li.first {
    border-radius: 5px 0px 0px 5px;
}
.pagination li.last {
    border-radius: 0px 5px 5px 0px;
}
.pagination li:hover{
	background: #CFF;
}
.pagination li.active{
	background: #F0F0F0;
	color: #333;
}
</style>
<div class="loading-div"></div>
<div id="results"><!-- content will be loaded here --></div>
