@php
    $message = null;
    $title   = 'Berhasil!';

    if (session('success')) {
        $message = session('success');
    } elseif (session('status') === 'profile-updated') {
        $message = 'Profil berhasil diperbarui!';
    } elseif (session('status') === 'password-updated') {
        $message = 'Password berhasil diperbarui!';
    }
@endphp

@if($message)
<div id="success-modal-overlay" class="fixed inset-0 z-[9999] flex items-center justify-center p-4" style="background:rgba(0,0,0,0.45);">
    <div id="success-modal-box" class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-8 text-center" style="animation:successModalIn .3s cubic-bezier(.34,1.56,.64,1) both">

        <!-- Icon -->
        <div class="flex items-center justify-center mx-auto mb-5 w-20 h-20 rounded-full bg-green-100">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <!-- Title & Message -->
        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $title }}</h3>
        <p class="text-gray-600 text-sm leading-relaxed mb-6">{{ $message }}</p>

        <!-- Progress bar -->
        <div class="w-full h-1 bg-gray-100 rounded-full overflow-hidden mb-5">
            <div id="success-modal-bar" class="h-1 bg-green-500 rounded-full" style="width:100%"></div>
        </div>

        <!-- Close button -->
        <button onclick="closeSuccessModal()" class="w-full py-2.5 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl transition">
            OK
        </button>
    </div>
</div>

<style>
@keyframes successModalIn {
    from { opacity:0; transform:scale(.85) translateY(20px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
}
</style>

<script>
(function () {
    const DURATION = 4000;
    const bar      = document.getElementById('success-modal-bar');
    const overlay  = document.getElementById('success-modal-overlay');
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
            closeSuccessModal();
        }
    }

    raf = requestAnimationFrame(tick);

    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closeSuccessModal();
    });

    window.closeSuccessModal = function () {
        cancelAnimationFrame(raf);
        overlay.style.transition = 'opacity .2s';
        overlay.style.opacity    = '0';
        setTimeout(() => overlay.remove(), 200);
    };
})();
</script>
@endif
