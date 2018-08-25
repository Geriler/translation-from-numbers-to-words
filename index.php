<?php
$numbers = json_decode(file_get_contents('./numbers.json'));
$_POST['number'] = (int)$_POST['number'];
preg_match_all('/\d/', $_POST['number'], $matches);
$matches = $matches[0];
$numRegex = sizeof($matches);

if ($numRegex == 1) {
	$num = $matches[$numRegex - 1];
	$words[0][0] = $numbers->$num;
}
if ($numRegex >= 2) {
	$num2 = $matches[$numRegex - 3] * 100;
	if (check($matches, $numRegex)) {
		$num = $matches[$numRegex - 2] . $matches[$numRegex - 1];
		$words[0][0] = $numbers->$num;
	} else {
		$num0 = $matches[$numRegex - 1];
		$num1 = $matches[$numRegex - 2] * 10;
		if ($num0 != 0) $words[0][0] = $numbers->$num0;
		$words[0][1] = $numbers->$num1;
		if ($num2 != 0) $words[0][2] = $numbers->$num2;
	}
}

if ($numRegex == 4) {
	$num = $matches[$numRegex - 4];
	if ($num == 1) $words[1][0] = 'одна тысяча';
	if ($num == 2) $words[1][0] = 'две тысячи';
	if ($num == 3 || $num == 4) $words[1][0] = $numbers->$num . ' тысячи';
	else $words[1][0] = $numbers->$num . ' тысяч';
}
if ($numRegex >= 5) {
	$num2 = $matches[$numRegex - 6] * 100;
	if (check($matches, ($numRegex - 3))) {
		$num = $matches[$numRegex - 5] . $matches[$numRegex - 4];
		$words[1][0] = $numbers->$num . ' тысяч';
		if ($num2 != 0) $words[1][1] = $numbers->$num2;
	} else {
		$num0 = $matches[$numRegex - 4];
		$num1 = $matches[$numRegex - 5] * 10;
		if ($num0 != 0) {
			if ($num0 == 1) $words[1][0] = 'одна тысяча';
			if ($num0 == 2) $words[1][0] = 'две тысячи';
			if ($num0 == 3 || $num == 4) $words[1][0] = $numbers->$num0 . ' тысячи';
			else $words[1][0] = $numbers->$num0 . ' тысяч';
		}
		if ($num1 != 0) $words[1][1] = $numbers->$num1;
		if ($num2 != 0) $words[1][2] = $numbers->$num2;
	}
}

if ($numRegex == 7) {
	$num = $matches[$numRegex - 7];
	if ($num == 1) $words[2][0] = $numbers->$num . ' миллион';
	if ($num == 2  || $num == 3 || $num == 4) $words[2][0] = $numbers->$num . ' миллиона';
	else $words[2][0] = $numbers->$num . ' миллионов';
}
if ($numRegex >= 8) {
	$num2 = $matches[$numRegex - 9] * 100;
	if (check($matches, ($numRegex - 3))) {
		$num = $matches[$numRegex - 8] . $matches[$numRegex - 7];
		$words[2][0] = $numbers->$num . ' тысяч';
		if ($num2 != 0) $words[2][1] = $numbers->$num2;
	} else {
		$num0 = $matches[$numRegex - 7];
		$num1 = $matches[$numRegex - 8] * 10;
		if ($num0 != 0) {
			if ($num0 == 1) $words[2][0] = $numbers->$num0 . ' миллион';
			if ($num0 == 2  || $num0 == 3 || $num0 == 4) $words[2][0] = $numbers->$num0 . ' миллиона';
			else $words[2][0] = $numbers->$num0 . ' миллионов';
		}
		if ($num1 != 0) $words[2][1] = $numbers->$num1;
		if ($num2 != 0) $words[2][2] = $numbers->$num2;
	}
}
function check($matches, $count) {
	$nums = $matches[$count - 2] . $matches[$count - 1];
	if ($nums >= 10 && $nums < 20) return true;
	else return false;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Перевод из слов в числа</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/style.css">
	</head>
	<body>
		<div class="container">
			<h2>Перевод из чисел в слова</h2>
			<hr>
			<div class="form">
				<form action="index.php" method="post">
					<input type="number" name="number" min="0" max="999999999" value="<?=$_POST['number']?>">
					<input class="btn btn-primary" type="submit" value="Перевести">
				</form>
			</div>
			<hr>
			<div class="number">
				<p>
					<?php
					for ($i = sizeof($words); $i >= 0; $i--) {
						for ($j = sizeof($words[$i]); $j >= 0; $j--) {
							echo $words[$i][$j] . " ";
						}
					}
					?>
				</p>
			</div>
		</div>
	</body>
</html>
