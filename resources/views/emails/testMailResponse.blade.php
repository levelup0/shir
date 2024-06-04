<!DOCTYPE html>
<html>

<head>
    <title>Шторм-трэк</title>
    <style>
        .container {
            display: block;
            color: black;
        }

        .div1 {
            display: block;
        }

        .div2 {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>{{ $testMailData['title'] }}</h1>
        <div class="div1">
            <div class="div2">
                <p style="color: black;">Текст:</p>
                <span style="font-weight: 600;color: black;">{{ $testMailData['text_1'] }}</span>
            </div>
        </div>
        <div style="margin-top: 10px;color: black;">
            Поздравляем! Ваша заявка на реализацию вызова в Шторм-треке принята!
        </div>
        <div style="margin-top: 10px;color: black;">
            {{ $testMailData['text_2'] }}
        </div>

        <div style="margin-top: 10px;color: black;">
            Контакты Вызоводателя
        </div>

        <div class="div1" style="margin-top: 10px">
            <span style="display: block; color: black;">TG:</span>
            <span style="display: block; color: black;font-weight: 600;">{{ $testMailData['text_3'] }}</span>
        </div>
        <div class="div1" style="margin-top: 10px">
            <span style="display: block; color: black;">Email:</span>
            <span style="display: block; color: black;font-weight: 600;">{{ $testMailData['text_4'] }}</span>
        </div>

        <div style="margin-top: 10px;color: black;">
            Удачи!
        </div>
    </div>
</body>

</html>
