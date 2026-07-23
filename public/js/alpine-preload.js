// =====================================================================
// PRAYER WIDGET COMPONENTS — Preloaded synchronously BEFORE Livewire
// loads Alpine. This guarantees window.* functions exist when Alpine
// evaluates x-data attribues, avoiding the Vite module (deferred) vs
// Livewire Alpine (synchronous) timing conflict.
// =====================================================================
window.prayerWidgetSidebar = function () {
    return {
        show: true,
        minimized: false,
        ready: false,

        init() {
            setTimeout(
                function () {
                    this.ready = true;
                    this.minimized = window.innerWidth < 1024;
                }.bind(this),
                1500,
            );
        },
    };
};

window.prayerTimeWidget = function () {
    return {
        loading: true,
        error: null,
        location: "Jakarta, Indonesia",
        latitude: -6.2088,
        longitude: 106.8456,
        currentTime: "",
        currentDate: "",
        prayerTimes: [],
        nextPrayer: null,
        countdown: { hours: "00", minutes: "00", seconds: "00" },
        timeInterval: null,
        countdownInterval: null,
        lastDate: null,

        init() {
            this.updateCurrentTime();
            this.timeInterval = setInterval(
                function () {
                    this.updateCurrentTime();
                }.bind(this),
                1000,
            );
            var self = this;
            var deferredInit = function () {
                self.getUserLocation();
            };
            if (window.requestIdleCallback) {
                requestIdleCallback(deferredInit, { timeout: 3000 });
            } else {
                setTimeout(deferredInit, 1000);
            }
        },

        async getUserLocation() {
            if (!navigator.geolocation) {
                this.fetchPrayerTimes();
                return;
            }
            if (navigator.permissions) {
                try {
                    var perm = await navigator.permissions.query({
                        name: "geolocation",
                    });
                    if (perm.state === "denied") {
                        this.fetchPrayerTimes();
                        return;
                    }
                } catch (e) {
                    /* ignore */
                }
            }
            var self = this;
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    self.latitude = position.coords.latitude;
                    self.longitude = position.coords.longitude;
                    self.reverseGeocode();
                    self.fetchPrayerTimes();
                },
                function () {
                    self.fetchPrayerTimes();
                },
                {
                    timeout: 10000,
                    maximumAge: 300000,
                    enableHighAccuracy: false,
                },
            );
        },

        async reverseGeocode() {
            try {
                var self = this;
                var r = await fetch(
                    "https://nominatim.openstreetmap.org/reverse?lat=" +
                        this.latitude +
                        "&lon=" +
                        this.longitude +
                        "&format=json",
                );
                var d = await r.json();
                if (d.address) {
                    var city =
                        d.address.city ||
                        d.address.town ||
                        d.address.village ||
                        d.address.county;
                    var state = d.address.state;
                    this.location =
                        city && state ? city + ", " + state : "Indonesia";
                }
            } catch (e) {
                /* ignore */
            }
        },

        async fetchPrayerTimes() {
            try {
                var self = this;
                var today = new Date();
                var dateStr =
                    today.getFullYear() +
                    "-" +
                    String(today.getMonth() + 1).padStart(2, "0") +
                    "-" +
                    String(today.getDate()).padStart(2, "0");
                var url =
                    "https://api.aladhan.com/v1/timings/" +
                    dateStr +
                    "?latitude=" +
                    this.latitude +
                    "&longitude=" +
                    this.longitude +
                    "&method=11&adjustment=1";
                var r = await fetch(url);
                var data = await r.json();
                if (data.code === 200 && data.data) {
                    var timings = data.data.timings;
                    var dateInfo = data.data.date;
                    var prayerList = [
                        { name: "Subuh", key: "Fajr" },
                        { name: "Dzuhur", key: "Dhuhr" },
                        { name: "Ashar", key: "Asr" },
                        { name: "Maghrib", key: "Maghrib" },
                        { name: "Isya", key: "Isha" },
                    ];
                    var times = [];
                    var now = new Date();
                    var currentSeconds =
                        now.getHours() * 3600 +
                        now.getMinutes() * 60 +
                        now.getSeconds();
                    var nextPrayer = null;
                    for (var i = 0; i < prayerList.length; i++) {
                        var p = prayerList[i];
                        var timeStr = timings[p.key];
                        if (!timeStr) continue;
                        var parts = timeStr.split(":");
                        var totalSec =
                            parseInt(parts[0]) * 3600 + parseInt(parts[1]) * 60;
                        var prayerDate = new Date(now);
                        prayerDate.setHours(
                            parseInt(parts[0]),
                            parseInt(parts[1]),
                            0,
                            0,
                        );
                        var displayTime = parts[0] + ":" + parts[1];
                        times.push({
                            name: p.name,
                            nameAr:
                                p.key === "Fajr"
                                    ? "الفجر"
                                    : p.key === "Dhuhr"
                                      ? "الظهر"
                                      : p.key === "Asr"
                                        ? "العصر"
                                        : p.key === "Maghrib"
                                          ? "المغرب"
                                          : "العشاء",
                            time: displayTime,
                            isNext: false,
                            isPast: totalSec < currentSeconds,
                            date: prayerDate,
                        });
                        if (!nextPrayer && totalSec > currentSeconds) {
                            nextPrayer = {
                                name: p.name,
                                time: displayTime,
                                seconds: totalSec - currentSeconds,
                            };
                            times[times.length - 1].isNext = true;
                        }
                    }
                    if (nextPrayer) {
                        this.startCountdown(nextPrayer.seconds);
                    }
                    this.prayerTimes = times;
                    this.loading = false;
                    this.error = null;
                } else {
                    throw new Error("Invalid response");
                }
            } catch (e) {
                this.error = "Gagal memuat jadwal sholat";
                this.loading = false;
            }
        },

        startCountdown(seconds) {
            var self = this;
            if (this.countdownInterval) clearInterval(this.countdownInterval);
            var remaining = seconds;
            this.countdownInterval = setInterval(function () {
                if (remaining <= 0) {
                    self.fetchPrayerTimes();
                    return;
                }
                remaining--;
                var h = Math.floor(remaining / 3600);
                var m = Math.floor((remaining % 3600) / 60);
                var s = remaining % 60;
                self.countdown = {
                    hours: String(h).padStart(2, "0"),
                    minutes: String(m).padStart(2, "0"),
                    seconds: String(s).padStart(2, "0"),
                };
            }, 1000);
        },

        updateCurrentTime() {
            var now = new Date();
            var hours = String(now.getHours()).padStart(2, "0");
            var minutes = String(now.getMinutes()).padStart(2, "0");
            var seconds = String(now.getSeconds()).padStart(2, "0");
            this.currentTime = hours + ":" + minutes + ":" + seconds;
            var days = [
                "Minggu",
                "Senin",
                "Selasa",
                "Rabu",
                "Kamis",
                "Jumat",
                "Sabtu",
            ];
            var months = [
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni",
                "Juli",
                "Agustus",
                "September",
                "Oktober",
                "November",
                "Desember",
            ];
            this.currentDate =
                days[now.getDay()] +
                ", " +
                now.getDate() +
                " " +
                months[now.getMonth()] +
                " " +
                now.getFullYear();
            if (this.lastDate && this.lastDate !== now.toDateString())
                this.fetchPrayerTimes();
            this.lastDate = now.toDateString();
        },

        destroy() {
            if (this.timeInterval) clearInterval(this.timeInterval);
            if (this.countdownInterval) clearInterval(this.countdownInterval);
        },
    };
};

// =====================================================================
// RUPIAH FORMATTING HELPER — Used by Livewire financing calculator
// for real-time currency formatting on input fields via Alpine.
// x-init="window.formatRupiah.init($el, 'fieldName')" must resolve
// synchronously when Alpine evaluates the DOM.
// =====================================================================
window.formatRupiah = {
    init(el, wireField) {
        if (window.Livewire) {
            var val = window.Livewire.find(el)?.get?.(wireField);
            if (val) el.value = this.fmt(val);
        }
    },
    fmt(v) {
        return v
            ? Number(String(v).replace(/[^0-9]/g, "")).toLocaleString("id-ID")
            : "";
    },
    raw(v) {
        return String(v).replace(/[^0-9]/g, "");
    },
    input(el, wireField) {
        var raw = this.raw(el.value);
        var formatted = raw ? Number(raw).toLocaleString("id-ID") : "";
        var pos = el.selectionStart;
        var oldLen = el.value.length;

        // Guard: skip if already formatted — prevents re-entrant loop
        // caused by el.value = formatted firing another @input event.
        if (el.value === formatted) return;

        el.value = formatted;
        var newPos = pos + (formatted.length - oldLen);
        // Clamp to avoid negative/max position
        if (newPos < 0) newPos = 0;
        if (newPos > formatted.length) newPos = formatted.length;
        el.setSelectionRange(newPos, newPos);
        if (window.Livewire) {
            var comp = window.Livewire.find(el);
            if (comp) comp.set(wireField, raw, false);
        }
    },
    blur(el, wireField) {
        if (!window.Livewire) return;
        var comp = window.Livewire.find(el);
        if (!comp) return; // component not found, leave field as-is
        var val = comp.get(wireField);
        el.value = val ? this.fmt(val) : el.value; // fallback to current value
    },
};
