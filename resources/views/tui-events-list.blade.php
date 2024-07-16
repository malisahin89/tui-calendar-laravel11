<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etkinlit Listele</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
</head>

<body>
    <div class="container">
        <h2>Event List</h2>



        <div class="row mb-3">
            <div class="col-md-6">
                <form method="POST" action="{{ route('event.list.search') }}" class="input-group">
                    @csrf
                    <div class="input-group-prepend">
                        <span class="input-group-text">Ay ve Yıl Seçin:</span>
                    </div>
                    <input type="text" name="date" class="form-control datepicker" placeholder="Ay/Yıl seçin">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Ara</button>
                    </div>
                </form>
            </div>
        </div>



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


        <div class="text-right">
            <form method="POST" action="{{ route('event.list.topdf') }}" class="input-group">
                @csrf
                <input type="hidden" name="date" class="form-control datepicker" placeholder="Ay/Yıl seçin">
                <button class="btn btn-success">PDF oluştur</button>
            </form>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $('.datepicker').datepicker({
            format: "mm/yyyy",
            startView: "months",
            minViewMode: "months",
            autoclose: true
        });
    </script>

    <script>
        $(document).ready(function() {
            var today = new Date();
            var month = today.getMonth() + 1;
            var year = today.getFullYear();

            @if (isset($date))
                var defaultDate = "{{ $date }}";
            @else
                var defaultDate = ("0" + month).slice(-2) + '/' + year;
            @endif
            $('.datepicker').datepicker({
                format: "mm/yyyy",
                startView: "months",
                minViewMode: "months",
                autoclose: true,
                endDate: '+0m',
            }).datepicker('setDate', defaultDate);
        });
    </script>
</body>

</html>
