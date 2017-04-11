
	
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="icon" href="pictures/logo.png">
    
    <!-- jquery and bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight.js"></script>
    
    <!-- webfont -->
    <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster+Two" rel="stylesheet">
    <!-- style sheet -->
    <link rel="stylesheet" type="text/css" href="css/style.css">

	<style type="text/css">

		html, body {
		  height: 100%;
		}


		#wrap {
		  min-height: 100%;
		}

		#main {
		  overflow:auto;
		  padding-bottom:50px; /* this needs to be bigger than footer height*/
		}

		.footer {
		  position: relative;
		  margin-top: -50px; /* negative value of footer height */
		  height: 50px;
		  clear:both;
		  padding-top:20px;
		} 
		
		.margin-left{
			margin-left:4%;
		}

@media(max-width:500px){
	body{
		/*background-color: black;*/
	}
	.book_image {
			height: 100px;
			width: 33%;	
			display: flex;
			align-items: right;
			/*border:1px solid;*/

		}
}
@media(min-width:500px){
	body{
		/*background-color: yellow;*/
	}
	.book_image {
			height: 120px;
			width: 33%;	
			display: flex;
			align-items: right;
			/*border:1px solid;*/

		}
}
@media(min-width:600px){
	body{
		/*background-color: blue;*/
	}
	.book_image {
			height: 150px;
			width: 33%;	
			display: flex;
			align-items: right;
			/*border:1px solid;*/

		}
}
@media(min-width:700px){
	body{
		/*background-color:black;*/
	}
	.book_image {
			height: 200px;
			width: 33%;	
			display: flex;
			align-items: right;
			/*border:1px solid;*/

		}
}
@media(min-width:768px){
	body{
		/*background-color:red;*/
	}
	.book_image {
			height: 190px;
			width: 33%;	
			display: flex;
			align-items: right;
			/*border:1px solid;*/

		}
}
@media(min-width:992px){
	body{
		/*background-color:green;*/
	}
	.book_image {
			height: 110px;
			width: 33%;	
			display: flex;
			align-items: center;
			/*border:1px solid;*/
		}
}
@media(min-width:1200px){
	body{
		/*background-color:yellow;*/
	}
	.book_image {
			height: 150px;
			width: 33%;	
			display: flex;
			align-items: right;
			/*border:1px solid;*/

		}
}



		.reduce_top_margin{
			/*margin-top: -60px;*/
			/*margin-right: 20px;*/
			top:-10px;
			right:20px;
			position: absolute;
		}

		.header_margin {
			margin-top: 100px;
		}
		
		.book_image img {
			height: 100%;
			width: 100%;
		}
		.book_form {
			/*height: 150px;*/
			display: flex;
			align-items: center;
			margin-left: auto;
			margin-right: auto;
			/*border: 1px solid;*/
		}
		.book_form hr {
			margin-top: -2px;
			margin-bottom: 2px;
		}
		.book_header  {
			width: 100%;
			/*border: 1px solid;*/
			padding: 10px;
			height: 70px;
		}
		.selected_book_header  {
			width: 100%;
			/*border: 1px solid;*/
			padding: 10px;
			/*height: 60px;*/
		}
		.book_header_author  {
			width: 100%;
			/*border: 1px solid;*/
			padding: 10px;
			/*height: 100px;*/
		}
		.book_form * {
			/*border: 1px solid;*/
		}
		.max-width {
			width: 100%;
		}
		.wrapper {
			padding:4px;
		}
		.selected_book {
			font-size: 1.4em;
		}
		.selected_book h4 {
			font-size: 1.2em;
		}

		.selected_book .book_image {
			height: 220px;
			width: 280px;
		}
		
	</style>
