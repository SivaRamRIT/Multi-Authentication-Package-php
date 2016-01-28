<?php
require 'src/Barcodebase.php';
require 'src/Code128.php';

$bcode = array();
$bcode['c128']	= array('name' => 'Code128', 'obj' => new emberlabs\Barcode\Code128());

function bcode_error($m)
{
	echo "<div class='error'>{$m}</div>";
}

function bcode_success($bcode_name)
{
	echo "<div class='success'>A $bcode_name barcode was successfully created</div>";
}

function bcode_img64($b64str)
{
	echo "<img src='data:image/png;base64,$b64str' /><br />";
}

?>
<!DOCTYPE html>
<html>
<head>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Title of the document</title>

</head>

<body>

 <div class="container">
            <h3>Custom ID Creation</h3>
            <div class="form-container">

<form action="customID-creation-example.php" method="post">

Enter unique ID: <input type="text" name="encode" value="" /><br />
<input type="submit" value="Encode" name="submit" />

</form>
</div>
</div>

</body>

</html>

<?php 

if (isset($_POST['submit'])) {

	foreach($bcode as $k => $value)
	{
		try
		{
			$bcode[$k]['obj']->setData($_POST['encode']);
			$bcode[$k]['obj']->setDimensions(640, 480);
			$bcode[$k]['obj']->draw();
			$b64 = $bcode[$k]['obj']->base64();

			bcode_success($bcode[$k]['name']);
			bcode_img64($b64);
		}
		catch (Exception $e)
		{
			bcode_error($e->getMessage());
		}
	}
}
?>

