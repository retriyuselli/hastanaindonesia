@if($errors->any())
<div id="error-modal-overlay" class="fixed inset-0 z-[9999] flex items-center justify-center p-4" style="background:rgba(0,0,0,0.45);">
    <div id="error-modal-box" class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-8 text-center" style="animation:errorModalIn .3s cubic-bezier(.34,1.56,.64,1) both">

        <!-- Icon -->
        <div class="flex items-center justify-center mx-auto mb-5 w-20 h-20 rounded-full bg-red-100">
            <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>

        <!-- Title -->
        <h3 class="text-xl font-bold text-gray-900 mb-2">Terdapat Kesalahan</h3>
        <p class="text-gray-500 text-sm mb-4">Mohon periksa dan perbaiki isian berikut:</p>

        <!-- Error list -->
        <ul class="text-left text-sm text-red-700 bg-red-50 rounded-xl px-4 py-3 space-y-1 mb-6 max-h-48 overflow-y-auto">
            @foreach($errors->all() as $error)
                <li class="flex items-start gap-2">
                    <span class="mt-0.5 shrink-0">•</span>
                    <span>{{ $error }}</span>
                </li>
            @endforeach
        </ul>

        <!-- Progress bar -->
        <div class="w-full h-1 bg-gray-100 rounded-full overflow-hidden mb-5">
            <div id="error-modal-bar" class="h-1 bg-red-500 rounded-full" style="width:100%"></div>
        </div>

        <!-- Close button -->
        <button onclick="closeErrorModal()" class="w-full py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl transition">
            Tutup & Perbaiki
        </button>
    </div>
</div>

<style>
@keyframes errorModalIn {
    from { opacity:0; transform:scale(.85) translateY(20px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
}
</style>

<script>
(function () {
    const DURATION = 6000;
    const bar      = document.getElementById('error-modal-bar');
    const overlay  = document.getElementById('error-modal-overlay');
    let start      = null;
    let raf        = null;

    function tick(ts) {
        if (!start) start = ts;
        const elapsed = ts - start;
        const pct     = Math.max(0, 100 - (elapsed / DURATION) * 100);
        bar.style.width = pct + '%';
        if (elapsed < DURATION) {
            raf = requestAnimationFrame(tick);
        } else {
            closeErrorModal();
        }
    }

    raf = requestAnimationFrame(tick);

    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closeErrorModal();
    });

    window.closeErrorModal = function () {
        cancelAnimationFrame(raf);
        overlay.style.transition = 'opacity .2s';
        overlay.style.opacity    = '0';
        setTimeout(() => overlay.remove(), 200);
    };
})();
</script>
@endif
