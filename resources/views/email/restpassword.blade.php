<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>注册确认链接</title>
</head>
<body>
<h1>您在 zhihu-app 网站找回您的密码！</h1>

<p>
    请点击下面链接完成注册：
    <a href="{{ route('password.reset', $token) }}"></a>
    {{ route('password.reset', $token) }}
</p>

<p>
    如果不是你本人的操作，请忽略此邮件。
</p>
</body>
</html>