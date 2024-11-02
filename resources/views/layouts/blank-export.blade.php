<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>@yield('title')</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/atlantis.css">
    <link rel="stylesheet" href="/assets/css/demo.css">
</head>
@yield('css-script')
<body class="@yield('body-class')"  >
	@yield('body')
	@yield('js-script')
</body>
</html>
