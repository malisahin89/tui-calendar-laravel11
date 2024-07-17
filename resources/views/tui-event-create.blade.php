<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Takvim</title>
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.css" />
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.css" />
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
    <link rel="stylesheet" href="https://uicdn.toast.com/select-box/latest/toastui-select-box.css" />
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.11.5/dayjs.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('tuicalendar/style.css') }}" />
</head>

<body>
    <div class="mask"></div>
    <div id="app">
        <h1><span>Etkinlik Oluştur - Şuanki Zaman: </span><span id="time"></span></h1>
        <div class="head">
            <div class="left">
                <button class="btn" id="todayButton" onclick="today()">Bugün</button>
                <button class="btn round" onclick="next(-12)">- Yıl</button>
                <button class="btn round" onclick="next(-1)">- Ay</button>
                <span id="date"></span>
                <button class="btn round" onclick="next()">+ Ay</button>
                <button class="btn round" onclick="next(12)">+ Yıl</button>
            </div>
            <div class="right">
                <button class="btn" onclick="removeAll()">Tümünü Temizle</button>
            </div>
        </div>
        <div id="main"></div>
    </div>
    <script src="https://uicdn.toast.com/select-box/latest/toastui-select-box.js"></script>
    <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
    <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
    <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/store@2.0.12/dist/store.everything.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <script>
        var Calendar = window.tui.Calendar;
        var events = []

        events = events.map(item => {
            item.start = dayjs(item.start).toDate();
            item.end = dayjs(item.end).toDate();
            return item;
        });

        var cal = new Calendar('#main', {
            defaultView: 'month',
            usageStatistics: false,
            theme: {
                common: {
                    backgroundColor: 'transparent'
                }
            },

            calendars: [
                @if (count($users) > 0)
                    @foreach ($users as $user)
                        {
                            id: '{{ $user->id }}',
                            name: '{{ $user->name }}',
                            color: '#ffffff',
                            borderColor: '{{ substr($user->color, 0, -3) }}',
                            backgroundColor: '{{ $user->color }}',
                            dragBackgroundColor: '{{ $user->color }}',
                        },
                    @endforeach
                @endif
            ],

            useFormPopup: true,
            useDetailPopup: true,
            useStatePopup: false,
            template: {
                popupIsAllday: function() {
                    return 'All day?';
                },
                popupStateFree: function() {
                    return '🏝️ Free';
                },
                popupStateBusy: function() {
                    return '🔥 Busy';
                },
                titlePlaceholder: function() {
                    return 'Başlık';
                },
                locationPlaceholder: function() {
                    return 'Açıklama';
                },
                startDatePlaceholder: function() {
                    return 'Start date';
                },
                endDatePlaceholder: function() {
                    return 'End date';
                },
                popupSave: function() {
                    return 'Add Event';
                },
                popupUpdate: function() {
                    return 'Update Event';
                },
                popupEdit: function() {
                    return 'Modify';
                },
                popupDelete: function() {
                    return 'Remove';
                },
                popupDetailTitle: function(data) {
                    return 'Detail of ' + data.title;
                },
            },
        });

        cal.createEvents([
            @if (count($datas) > 0)
                @foreach ($datas as $data)
                    {
                        id: '{{ $data->id }}',
                        calendarId: '{{ $data->calendar_id }}',
                        title: '{{ $data->title }}',
                        location: '{{ $data->content }}',
                        isPrivate: {{ $data->is_private }},
                        isAllday: {{ $data->is_allday }},
                        state: '{{ $data->state }}',
                        category: 'time',
                        dueDateClass: '',
                        start: '{{ $data->start }}',
                        end: '{{ $data->end }}',
                    },
                @endforeach
            @endif
        ]);

        function changeEventId(oldId, newId) {
            var event = events.find(e => e.id === oldId);
            if (event) {
                event.id = newId;
                cal.updateEvent(oldId, event.calendarId, {
                    id: newId
                });
            }
        }


        function addItem(obj) {
            events.push(obj);

            $.ajax({
                type: "POST",
                url: "{{ route('event.create.store') }}",
                data: JSON.stringify(obj),
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log("Veri başarıyla kaydedildi: ", response);
                    toastr.success(response.message);
                    changeEventId(obj.id, response.newID);
                },
                error: function(xhr, status, response) {
                    console.error("Veri kaydedilemedi: ", response);
                    toastr.error(response.message);
                }
            });
        }

        function updateItem(obj) {
            var index;
            events.forEach((item, i) => {
                if (item.id == obj.id) {
                    index = i;
                }
            });
            if (index !== undefined) {
                events[index] = obj;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('event.create.update') }}",
                data: JSON.stringify(obj),
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log("Veri başarıyla güncellendi: ", response);
                    toastr.success(response.message);
                },
                error: function(xhr, status, response) {
                    console.error("Veri güncellenemedi: ", response);
                    toastr.error(response.message);
                }
            });
        }

        function delItem(id) {
            events = events.filter(event => event.id !== id);

            $.ajax({
                type: "POST",
                url: "{{ route('event.create.destroy') }}",
                data: JSON.stringify({
                    id: id
                }),
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log("Veri başarıyla silindi: ", response);
                    toastr.success(response.message);
                },
                error: function(xhr, status, response) {
                    console.error("Veri silinemedi: ", response);
                    toastr.error(response.message);
                }
            });
        }
    </script>
      <script src="{{ asset('tuicalendar/app.js') }}"></script>
</body>

</html>
