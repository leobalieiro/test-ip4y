<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>

    @include('components.client_style')
    @include('components.client_script')
</head>

<body>
    @include('components.client_navbar')

    @include($page)
</body>

</html>
