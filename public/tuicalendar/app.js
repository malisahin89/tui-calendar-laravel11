    // var Calendar = window.tui.Calendar;
    // var events = store.get('events') || []




    // events = events.map(item => {
    //     item.start = dayjs(item.start).toDate(); // Tarihleri uygun formata dönüştür
    //     item.end = dayjs(item.end).toDate(); // Tarihleri uygun formata dönüştür
    //     return item;
    // });

    // var cal = new Calendar('#main', {
    //     defaultView: 'month',
    //     useFormPopup: true,
    //     useDetailPopup: true,
    //     theme: {
    //         common: {
    //             backgroundColor: 'transparent'
    //         }
    //     },
    //     calendars: [
    //         {
    //             id: '1',
    //             name: 'Önemli ve Acil',
    //             color: '#ffffff',
    //             borderColor: '#f00',
    //             backgroundColor: '#FF4136',
    //             dragBackgroundColor: '#FF4136',
    //         },
    //         {
    //             id: '2',
    //             name: 'Önemli Ama Acil Değil',
    //             color: '#ffffff',
    //             borderColor: '#0f0',
    //             backgroundColor: '#2ECC40',
    //             dragBackgroundColor: '#2ECC40',
    //         },
    //         {
    //             id: '3',
    //             name: 'Acil Ama Önemli Değil',
    //             color: '#fff',
    //             borderColor: '#00f',
    //             backgroundColor: '#0074D9',
    //             dragBackgroundColor: '#0074D9',
    //         },
    //         {
    //             id: '4',
    //             name: 'Ne Acil Ne Önemli',
    //             color: '#ffffff',
    //             borderColor: '#000',
    //             backgroundColor: '#111',
    //             dragBackgroundColor: '#111',
    //         }
    //     ]
    // });

    // cal.createEvents(events);

    // function updateItem(obj) {
    //     var index;
    //     events.forEach((item, i) => {
    //         if (item.id == obj.id) {
    //             index = i;
    //         }
    //     });
    //     if (index !== undefined) {
    //         events[index] = obj;
    //     }
    //     store.set('events', events);
    // }

    function addItem(obj) {
        events.push(obj);
    }

    function delItem(obj) {
        events = events.filter(item => item.id != obj.id);
    }

    function initTime() {
        time.innerHTML = dayjs().format('YYYY-MM-DD HH:mm:ss');
    }

    function interval() {
        window.timer = setInterval(() => {
            initTime();
        }, 1000);
    }

    function renderYear() {
        var y = cal.getDate().getFullYear();
        var m = cal.getDate().getMonth() + 1;
        date.innerHTML = m + '. Ay ' + y;
    }

    cal.on('clickEvent', ({
        event
    }) => {
        // console.log(event)
    });

    cal.on('beforeUpdateEvent', ({
        event,
        changes
    }) => {
        cal.updateEvent(event.id, event.calendarId, {
            ...changes
        });
        const item = {
            ...event,
            ...changes
        };
        updateItem(item);
    });

    cal.on('beforeCreateEvent', (eventObj) => {
        const task = {
            ...eventObj,
            id: +new Date() + '',
            attendees: null,
            category: 'time'
        };
        var e = cal.createEvents([
            task
        ]);
        addItem(task);
    });

    cal.on('beforeDeleteEvent', (event) => {
        delItem(event);
        cal.deleteEvent(event.id, event.calendarId);
    });

    function next(num) {
        num = num || 1;
        cal.move(num);
        renderYear();
    }

    function prev() {
        cal.prev();
        renderYear();
    }

    function today() {
        cal.today();
        renderYear();
    }

    function removeAll() {
        var f = window.confirm('Tüm etkinlikleri silmek istediğinizden emin misiniz?');
        if (!f) return;
        events = [];
        cal.clear();
    }

    initTime();
    renderYear();
    interval();


