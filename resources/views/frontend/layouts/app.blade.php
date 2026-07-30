<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    try {
        $company = \App\Models\CompanyInfo::getInfo();
    } catch (\Throwable $e) {
        $company = null;
    }
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="0OtvQgB_NIsFOhRnDVRlMnKnunQZOerEvZ4RHNY7wbM" />

    <meta name="csp-nonce" content="{{ $nonce }}">

    {{-- SEO Meta Tags --}}
    {!! \App\Services\Seo\SeoMeta::generate() !!}

    {{-- DNS Prefetch & Preconnect for performance --}}
    <link rel="dns-prefetch" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>

    @if($company?->favicon)
    <link rel="icon" href="{{ \App\Helpers\StorageHelper::url($company->favicon) }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ \App\Helpers\StorageHelper::url($company->favicon) }}" type="image/x-icon">
    @endif

    {{-- Preload critical fonts --}}
    <link rel="preload" href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700,800|inter:400,500,600,700&display=swap" as="style">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700,800|inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/js/sweetalert-global.js', 'resources/js/app.js', 'resources/css/app.css'])
    @livewireStyles(['nonce' => $nonce])
    @stack('head')
    <script src="https://analytics.ahrefs.com/analytics.js" data-key="EU80N6YBFCctbdfGZIb5gg" async nonce="{{ $nonce }}"></script>
</head>
<body>

    {{-- Skip to main content link for keyboard users --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:p-4 focus:bg-white focus:text-emerald-600 focus:rounded-xl focus:shadow-xl focus:outline-none focus:border-2 focus:border-emerald-600 focus:font-semibold">
        Langsung ke konten utama
    </a>

    <main id="main-content"><!-- Header -->
    <header class="border-b border-border sticky top-0 z-50 bg-white">
        @include('frontend.partials.navbar')
    </header>

    {{-- Flash Messages — otomatis tampil sebagai SweetAlert2 toast via sweetalert-global.js --}}
    @php
        $__swalFlash = json_encode(array_filter([
            session('success') ? ['type' => 'success', 'title' => 'Berhasil!', 'text' => session('success')] : null,
            session('error') ? ['type' => 'error', 'title' => 'Gagal!', 'text' => session('error')] : null,
            session('warning') ? ['type' => 'warning', 'title' => 'Peringatan!', 'text' => session('warning')] : null,
            session('info') ? ['type' => 'info', 'title' => 'Informasi', 'text' => session('info')] : null,
        ]));
    @endphp
    <div id="swal-flash"
         data-messages='{!! $__swalFlash !!}'
         aria-hidden="true"
         style="display:none"></div>

    <!-- Main Content -->
    <main>
        @if(isset($slot) && $slot->isNotEmpty())
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    <!-- Footer -->
    @php
        $__footerKey = 'frontend_footer';
        $__footerTtl = now()->addHour();
    @endphp
    @if(!\Illuminate\Support\Facades\Cache::has($__footerKey))
        @php ob_start(); @endphp
    @endif
        @include('frontend.partials.footer')
    @if(!\Illuminate\Support\Facades\Cache::has($__footerKey))
        @php
            $__footerContent = ob_get_clean();
            echo $__footerContent;
            \Illuminate\Support\Facades\Cache::put($__footerKey, $__footerContent, $__footerTtl);
        @endphp
    @endif

    @if(request()->routeIs('home'))
    <!-- ═══ Floating Prayer Time Widget ═══ -->
    <div id="pfw-wrap" class="fixed right-4 bottom-4 z-50 pfw-hide">
        <style nonce="{{ $nonce }}">
            #pfw-wrap * { box-sizing:border-box; }
            #pfw-wrap .pfw-box { width:320px; max-height:75vh; overflow-y:auto; background:linear-gradient(135deg,#059669,#065f46); border-radius:16px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); }
            #pfw-wrap .pfw-toggle-btn { position:absolute; left:0; bottom:24px; transform:translateX(-100%); background:#059669; color:#fff; border:none; padding:10px 14px; border-radius:12px 0 0 12px; cursor:pointer; box-shadow:0 10px 25px rgba(0,0,0,0.2); transition:all .3s; z-index:10; }
            #pfw-wrap .pfw-toggle-btn:hover { background:#047857; }
            #pfw-wrap.pfw-hide .pfw-box { display:none; }
            #pfw-wrap.pfw-hide .pfw-toggle-btn { opacity:1; }
            #pfw-wrap:not(.pfw-hide) .pfw-toggle-btn { opacity:0; }
            #pfw-wrap:hover:not(.pfw-hide) .pfw-toggle-btn { opacity:1; }
            @keyframes pfw-spin { to{transform:rotate(360deg)} }
            @keyframes pfw-float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
            @keyframes pfw-glow { 0%,100%{box-shadow:0 0 8px rgba(255,255,255,0.15)} 50%{box-shadow:0 0 22px rgba(255,255,255,0.35)} }
            @keyframes pfw-tick { 0%{transform:scale(1)} 50%{transform:scale(1.15)} 100%{transform:scale(1)} }
            @keyframes pfw-up { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
            .pfw-spin { animation:pfw-spin .8s linear infinite; }
            .pfw-float { animation:pfw-float 4s ease-in-out infinite; }
            .pfw-glow { animation:pfw-glow 3s ease-in-out infinite; }
            .pfw-tick { animation:pfw-tick .15s ease-out; }
            .pfw-up { opacity:0; animation:pfw-up .5s cubic-bezier(0.16,1,0.3,1) forwards; }
            .pfw-entry { transition:background .2s; }
            .pfw-entry:hover { background:rgba(255,255,255,0.12) !important; }
            .pfw-entry.pfw-next:hover { background:rgba(255,255,255,0.28) !important; }
        </style>
        <button id="pfw-toggle" class="pfw-toggle-btn" aria-label="Toggle">
            <svg id="pfw-ico" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
        </button>
        <div class="pfw-box">
            <div class="pfw-up" style="padding:16px 20px;background:rgba(255,255,255,0.1);border-bottom:1px solid rgba(255,255,255,0.15);backdrop-filter:blur(8px)">
                <div class="pfw-up" style="animation-delay:.05s;display:flex;align-items:center;justify-content:space-between">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div class="pfw-float" style="width:40px;height:40px;background:rgba(255,255,255,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:#fff"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div><div style="color:#fff;font-weight:700;font-size:15px">Jadwal Sholat</div><div id="pfw-loc" style="color:rgba(255,255,255,0.7);font-size:13px">Memuat...</div></div>
                    </div>
                    <button id="pfw-refresh" style="padding:8px;background:none;border:none;cursor:pointer;border-radius:8px;color:#fff" title="Perbarui"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg></button>
                </div>
            </div>
            <div class="pfw-up" style="animation-delay:.1s;padding:10px 20px;background:rgba(255,255,255,0.05);border-bottom:1px solid rgba(255,255,255,0.1);text-align:center">
                <div id="pfw-clock" style="font-size:24px;font-weight:700;color:#fff"></div>
                <div id="pfw-date" style="color:rgba(255,255,255,0.7);font-size:13px"></div>
            </div>
            <div id="pfw-next" class="pfw-up pfw-glow" style="animation-delay:.15s;padding:14px 20px;background:rgba(255,255,255,0.1);border-bottom:1px solid rgba(255,255,255,0.1);text-align:center;display:none">
                <div style="color:rgba(255,255,255,0.7);font-size:13px;margin-bottom:4px">Menuju</div>
                <div id="pfw-nx" style="color:#fff;font-weight:700;font-size:16px;margin-bottom:10px"></div>
                <div style="display:flex;align-items:center;justify-content:center;gap:8px">
                    <div style="background:rgba(255,255,255,0.2);border-radius:8px;padding:8px 12px;min-width:52px;backdrop-filter:blur(4px)"><div id="pfw-ch" style="font-size:20px;font-weight:700;color:#fff"></div><div style="color:rgba(255,255,255,0.7);font-size:11px">Jam</div></div>
                    <div style="color:#fff;font-size:16px;animation:pfw-float 4s ease-in-out infinite">:</div>
                    <div style="background:rgba(255,255,255,0.2);border-radius:8px;padding:8px 12px;min-width:52px;backdrop-filter:blur(4px)"><div id="pfw-cm" style="font-size:20px;font-weight:700;color:#fff"></div><div style="color:rgba(255,255,255,0.7);font-size:11px">Menit</div></div>
                    <div style="color:#fff;font-size:16px;animation:pfw-float 4s ease-in-out infinite">:</div>
                    <div style="background:rgba(255,255,255,0.2);border-radius:8px;padding:8px 12px;min-width:52px;backdrop-filter:blur(4px)"><div id="pfw-cs" style="font-size:20px;font-weight:700;color:#fff"></div><div style="color:rgba(255,255,255,0.7);font-size:11px">Detik</div></div>
                </div>
            </div>
            <div id="pfw-list" style="padding:16px 20px">
                <div id="pfw-load" style="text-align:center;padding:20px 0"><div class="pfw-spin" style="display:inline-block;width:28px;height:28px;border:3px solid rgba(255,255,255,0.2);border-top-color:#fff;border-radius:50%"></div><p style="color:rgba(255,255,255,0.8);font-size:13px;margin-top:10px">Memuat...</p></div>
                <div id="pfw-err" style="text-align:center;padding:16px 0;display:none"><p id="pfw-err-msg" style="color:rgba(255,255,255,0.9);font-size:13px;margin-bottom:10px"></p><button id="pfw-retry" style="padding:8px 18px;background:rgba(255,255,255,0.2);border:none;color:#fff;border-radius:8px;cursor:pointer;font-size:13px">Coba Lagi</button></div>
                <div id="pfw-times" style="display:none"></div>
            </div>
            <div class="pfw-up" style="animation-delay:.3s;padding:10px 20px;background:rgba(255,255,255,0.05);border-top:1px solid rgba(255,255,255,0.1);text-align:center"><p style="color:rgba(255,255,255,0.5);font-size:11px">Diperbarui otomatis setiap hari</p></div>
        </div>
    </div>

    <script nonce="{{ $nonce }}">
    (function(){ 'use strict';
        var w=document.getElementById('pfw-wrap'), b=w.querySelector('.pfw-box'), t=document.getElementById('pfw-toggle'), ic=document.getElementById('pfw-ico'),
            loc=document.getElementById('pfw-loc'), clock=document.getElementById('pfw-clock'), dateEl=document.getElementById('pfw-date'),
            nx=document.getElementById('pfw-next'), nxName=document.getElementById('pfw-nx'),
            ch=document.getElementById('pfw-ch'), cm=document.getElementById('pfw-cm'), cs=document.getElementById('pfw-cs'),
            loadEl=document.getElementById('pfw-load'), errEl=document.getElementById('pfw-err'), errMsg=document.getElementById('pfw-err-msg'),
            timesEl=document.getElementById('pfw-times');
        var S={min:true,lat:-6.2088,lng:106.8456,loc:'Jakarta, Indonesia',times:[],next:null,cd:{h:'00',m:'00',s:'00'},intvls:[],autoTO:null,autoHideTO:null};
        function toggle(){S.min=!S.min;S.min?w.classList.add('pfw-hide'):(w.style.display='',w.classList.remove('pfw-hide'));t.style.opacity=S.min?'1':'0';ic.innerHTML=S.min?'<path d=\"M15 19l-7-7 7-7\"/>':'<path d=\"M9 5l7 7-7 7\"/>';resetAutoTO();}
        function resetAutoTO(){clearTimeout(S.autoTO);clearTimeout(S.autoHideTO);S.autoTO=setTimeout(function(){if(S.min){toggle();S.autoHideTO=setTimeout(function(){if(!S.min){toggle();}},15000);}},45000);}
        function loadTimes(){loadEl.style.display='';errEl.style.display='none';timesEl.style.display='none';
            var d=new Date(),ds=d.getFullYear()+'-'+String(d.getMonth()+1).padStart(2,'0')+'-'+String(d.getDate()).padStart(2,'0');
            fetch('https://api.aladhan.com/v1/timings/'+ds+'?latitude='+S.lat+'&longitude='+S.lng+'&method=11').then(function(r){return r.json()}).then(function(d){
                if(d.code!==200||!d.data)throw Error();
                var timings=d.data.timings,list=[{n:'Subuh',k:'Fajr'},{n:'Dzuhur',k:'Dhuhr'},{n:'Ashar',k:'Asr'},{n:'Maghrib',k:'Maghrib'},{n:'Isya',k:'Isha'}];
                var now=new Date(),cur=now.getHours()*3600+now.getMinutes()*60+now.getSeconds(),times=[],next=null;
                for(var i=0;i<list.length;i++){var p=list[i],ts=timings[p.k];if(!ts)continue;var pt=ts.split(':'),sec=parseInt(pt[0])*3600+parseInt(pt[1])*60;
                times.push({n:p.n,t:pt[0]+':'+pt[1],nx:false});if(!next&&sec>cur){next={n:p.n,t:pt[0]+':'+pt[1],s:sec-cur};times[times.length-1].nx=true;}}
                S.times=times;S.next=next;loadEl.style.display='none';
                var html='',icons=['🌅','☀️','🌤️','🌆','🌙'];
                for(i=0;i<times.length;i++){var x=times[i];html+='<div class=\"pfw-up pfw-entry'+(x.nx?' pfw-next':'')+'\" style=\"animation-delay:'+(.15+i*0.08)+'s;display:flex;align-items:center;justify-content:space-between;padding:10px 14px;border-radius:10px;margin-bottom:6px;background:'+(x.nx?'rgba(255,255,255,0.2);box-shadow:0 0 0 1px rgba(255,255,255,0.4)':'rgba(255,255,255,0.05)')+'\">'+
                    '<div style=\"display:flex;align-items:center;gap:10px\"><div style=\"width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;background:'+(x.nx?'rgba(255,255,255,0.3)':'rgba(255,255,255,0.1)')+'\">'+(icons[i]||'')+'</div><span style=\"color:#fff;font-weight:500;font-size:15px\">'+x.n+'</span></div>'+
                    '<div style=\"text-align:right\"><div style=\"color:#fff;font-weight:700;font-size:15px\">'+x.t+'</div>'+(x.nx?'<div style=\"color:rgba(255,255,255,0.8);font-size:11px\">Selanjutnya</div>':'')+'</div></div>';}
                timesEl.innerHTML=html;timesEl.style.display='';
                if(next){nx.style.display='';nxName.textContent=next.n;_.startCD(next.s);}else{nx.style.display='none';}
            }).catch(function(){loadEl.style.display='none';errEl.style.display='';errMsg.textContent='Gagal memuat jadwal sholat';});
        }
        t.addEventListener('click',toggle,false);
        document.getElementById('pfw-refresh').addEventListener('click',loadTimes,false);
        document.getElementById('pfw-retry').addEventListener('click',loadTimes,false);
        var _={startCD:function(sec){for(var i=1;i<S.intvls.length;i++)clearInterval(S.intvls[i]);S.intvls=[S.intvls[0]];
            var r=sec;S.intvls.push(setInterval(function(){if(r<=0){loadTimes();return;}r--;
                var h=Math.floor(r/3600),m=Math.floor((r%3600)/60),s=r%60,prev=S.cd.s;
                S.cd={h:String(h).padStart(2,'0'),m:String(m).padStart(2,'0'),s:String(s).padStart(2,'0')};
                ch.textContent=S.cd.h;cm.textContent=S.cd.m;cs.textContent=S.cd.s;
                if(S.cd.s!==prev){cs.classList.remove('pfw-tick');void cs.offsetWidth;cs.classList.add('pfw-tick');}
            },1000));}};
        var ci=setInterval(function(){var n=new Date();clock.textContent=String(n.getHours()).padStart(2,'0')+':'+String(n.getMinutes()).padStart(2,'0')+':'+String(n.getSeconds()).padStart(2,'0');
            dateEl.textContent=['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][n.getDay()]+', '+n.getDate()+' '+['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][n.getMonth()]+' '+n.getFullYear();},1000);
        S.intvls.push(ci);
        if(navigator.geolocation){navigator.geolocation.getCurrentPosition(function(p){S.lat=p.coords.latitude;S.lng=p.coords.longitude;
            fetch('https://nominatim.openstreetmap.org/reverse?lat='+S.lat+'&lon='+S.lng+'&format=json').then(function(r){return r.json()}).then(function(d){
                if(d.address){var c=d.address.city||d.address.town||d.address.village||d.address.county;if(c){S.loc=c+', '+(d.address.state||'Indonesia');loc.textContent=S.loc;}}
            }).catch(function(){});loadTimes();},function(){loadTimes();},{timeout:10000,maximumAge:300000,enableHighAccuracy:false});}else{loadTimes();}
        resetAutoTO();
    })();
    </script>
    @endif

    @livewireScripts(['nonce' => $nonce])
    @stack('scripts')
</body>
</html>
