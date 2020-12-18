<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Fadhli Zakiy is an Indonesia technology enthusiast, cybersecurity consultant, full stack developer and sustainability inventor">
	<meta name="keywords" content="JSON, PDF, JSON to PDF, Convert, JSON 2 PDF, JSON2PDF, Fadhli, Zakiy, Fadhlizakiy, FadhliZakiy, Fadhli Zakiy, ">
	<meta name="author" content="Fadhli Zakiy">
    <title>Smart JSON to PDF Converter - Crafted by Fadhli Zakiy</title>

    <!-- Bootstrap -->
	<link rel="icon" href="https://fadhlizakiy.com/images/elements/favicon.png" type="image/png">
    <link href="https://fadhlizakiy.com/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css?p=<?php echo rand();?>" rel="stylesheet">
    <link href="https://fadhlizakiy.com/css/scroll.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="row no_margin">
	<div class="fMain col-xs-12">
		<div class="fMainText">
			On the Fly JSON to PDF Converter
		</div>
		<div class="fMainSubText">
			Convert your JSON to PDF Online and Free without hassle with REST protocol
		</div>
		<div class="fMainSubText">
			in case you found bug or required further info please contact me 
			<a target="_blank" href="mailto:fadhli.zakiy@gmail.com">
				here
			</a>
		</div>
	</div>
</div>
<div class="row no_margin fMeansHolder">
	<div class="col-xs-12 col-sm-6 fMeans fMeans1">
		<div class="fApproach">
			Approach 1
		</div>
		<div class="fMainSubText">
			Web browser approach for Newbie
		</div>
		<div class="fForm">
			<form action="" method="post" >
				<div class="row">
					<div class="col-xs-12 col-md-9">
						<div class="fQuestion">
							Title <span>*</span>
						</div>
						<input class="fInput" type="text" name="title" value="Hellooo...">
					</div>
					<div class="col-xs-12 col-md-3">
						<div class="fQuestion">
							Layout <span>*</span>
						</div>
						<select class="fInput" name="layout">
							<option value="P">Portrait</option>
							<option value="L">Landscape</option>
						</select>
					</div>
				</div>
				
				<div class="fQuestion">
					JSON <span>*</span>
				</div>
				<textarea class="fInput" name="json">["Hello","Everyone","I","am","Zakiy"]</textarea>
				<input class="fSubmit" type="submit">
		
			</form>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 fMeans fMeans2">
		<div class="fApproach">
			Approach 2
		</div>
		<div class="fMainSubText">
			REST Protocol for IT Wizard
		</div>
		<div class>
					<table>
					<tr>
						<td>
							<div class="fCurlTitle">
								title
							</div>
						</td>
						<td>
							<div class="fCurlDesc">
								: The title of your PDF
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="fCurlTitle">
								layout
							</div>
						</td>
						<td>
							<div class="fCurlDesc">
								: P for Portrait & L for Landscape
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="fCurlTitle">
								json
							</div>
						</td>
						<td>
							<div class="fCurlDesc">
								: Your JSON data
							</div>
						</td>
					</tr>
					</table>
				</div>
		<div class="fCurl">
			curl -X POST 'https://json2pdf.fadhlizakiy.com/' \<br>
			--output your_output_name.pdf \<br>
			--data "title=Your-Title-Here&layout=P&json=[\"Hello\", \"Everyone\", \"I\", \"am\", \"Zakiy\"]"
		</div>
	</div>
</div>


	<div class="fFZ">
		Crafted by 
		<a target="_blank" href="https://fadhlizakiy.com/">
			FadhliZakiy.com
		</a>
	</div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://fadhlizakiy.com/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://fadhlizakiy.com/js/bootstrap.min.js"></script>
</body>
</html>