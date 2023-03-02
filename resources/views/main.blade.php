        <!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href='css/Style.css'>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<h1>Конвертация валют</h1>
<p>Выберите валюту и суммы, чтобы получить обменный курс</p>
<form action="/main" method="POST">
    @csrf
<div class="container">
    <div class="currency">
        <select id="currency-one" name="from" required>
            @foreach( $currencies as $currency => $value)
            <option value={{ $currency }}>{{$currency}}</option>
            @endforeach
        </select>
        <input name="count" type="number" id="amount-one" placeholder="0"/>
    </div>

    <div class="swap-rate-container">

        <div class="rate">
            <button type="submit" class="btn" id="swap">
                Рассчитать️
            </button></div>
    </div>

    <div class="currency">
        <select id="currency-two" name="to" required>
            @foreach( $currencies as $currency => $value)
                <option value={{ $currency }}>{{$currency}}</option>
            @endforeach
        </select>
        <input type="number" id="amount-two" placeholder="0" value="{{ $result }}" />
    </div>
</div>
</form>
</body>
</html>
