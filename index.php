<!-- @format -->
<?php
echo '<pre>';
print_r(dirname($_SERVER['SCRIPT_NAME']));
echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
</head>

<body>
    <h1><a href="<?php echo dirname($_SERVER['SCRIPT_NAME']);?>/Views/index2.html">Link</a></h1>
</body>

</html>