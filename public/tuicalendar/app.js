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
    var e = cal.createEvents([task]);
    addItem(task);
});

cal.on('beforeDeleteEvent', (event) => {
    delItem(event.id);
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
