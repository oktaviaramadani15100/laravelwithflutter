<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="/payment" method="POST">
        @csrf
        <input type="text" name="price">
        <input type="text" name="item_name">
        <input type="text" name="customer_firts_name">
        <input type="text" name="customer_email">

        <button type="submit">bayar</button>
    </form>
</body>
</html>