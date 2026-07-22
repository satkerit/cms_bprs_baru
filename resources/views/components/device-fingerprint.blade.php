<script nonce="{{ $nonce ?? request()->attributes->get('csp_nonce') ?? '' }}">
(function() {
    try {
        var fp = localStorage.getItem('bprs_device_fp');
        if (!fp) {
            var signals = [
                navigator.userAgent,
                navigator.language,
                navigator.platform,
                screen.colorDepth,
                screen.width + 'x' + screen.height,
                new Date().getTimezoneOffset(),
                navigator.hardwareConcurrency || '',
                navigator.deviceMemory || '',
            ];
            var raw = signals.join('|||');
            var hash = 0;
            for (var i = 0; i < raw.length; i++) {
                hash = ((hash << 5) - hash) + raw.charCodeAt(i);
                hash |= 0;
            }
            fp = Math.abs(hash).toString(36);
            try { localStorage.setItem('bprs_device_fp', fp); } catch(e) {}
        }
        // Set cookie readable by server
        var parts = [
            'bprs_device_fp=' + encodeURIComponent(fp),
            'path=/',
            'max-age=' + (365 * 24 * 60 * 60),
            'SameSite=Lax'
        ];
        if (location.protocol === 'https:') parts.push('Secure');
        document.cookie = parts.join('; ');
    } catch(e) {
        // Fingerprint unavailable — proceed without
        try { document.cookie = 'bprs_device_fp=; path=/; max-age=0'; } catch(ex) {}
    }
})();
</script>
