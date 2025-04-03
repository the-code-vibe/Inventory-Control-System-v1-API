<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha</title>
</head>
<body>
    <h2>Olá, {{ $name }}</h2>
    <p>Recebemos uma solicitação para redefinir sua senha. Clique no link abaixo para continuar:</p>
    <p><a href="{{ $resetLink }}" target="_blank">Redefinir Senha</a></p>
    <p>Se você não solicitou essa alteração, ignore este e-mail.</p>
</body>
</html>
