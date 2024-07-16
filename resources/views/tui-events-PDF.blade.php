<!DOCTYPE html>
<html lang="tr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etkinlik PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
</head>

<body>
    <div class="container">
        <br>
        <br><center><h2>{{ $date }} Tarihindeki Etkinlikler</h2></center>


        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Kullanıcı</th>
                    <th>Başlık</th>
                    <th>Açıklama</th>
                    <th>Başlangıç Saati</th>
                    <th>Bitiş Saati</th>
                    <th>Başlangıç Tarihi</th>
                    <th>Bitiş Tarihi</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($users as $user)
                    @php
                        $startDateTime = new DateTime($user->start);
                        $startDate = $startDateTime->format('Y-m-d');
                        $startTime = $startDateTime->format('H:i');

                        $endDateTime = new DateTime($user->end);
                        $endDate = $endDateTime->format('Y-m-d');
                        $endTime = $endDateTime->format('H:i');
                    @endphp


                    <tr style="border: 2px solid {{ $user->user->color }};">
                        <td>{{ $user->user->name }}</td>
                        <td>{{ $user->title }}</td>
                        <td>{{ $user->content }}</td>

                        <td>{{ $startTime }}</td>
                        <td>{{ $endTime }}</td>
                        <td>{{ $startDate }}</td>
                        <td>{{ $endDate }}</td>
                    </tr>
                @endforeach


            </tbody>
        </table>


    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>

</html>
