<!-- Modal Bukti Pembayaran -->
<div id="paymentProofModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 overflow-y-auto h-full w-full z-50" onclick="closePaymentProofModal()">
    <div class="relative top-10 mx-auto p-3 w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2 max-w-4xl" onclick="event.stopPropagation()">
        <!-- Close Button -->
        <button onclick="closePaymentProofModal()" 
                class="absolute -top-2 -right-2 z-10 w-10 h-10 bg-white hover:bg-gray-100 rounded-full shadow-lg flex items-center justify-center transition-colors">
            <i class="fas fa-times text-gray-700 text-xl"></i>
        </button>
        
        <!-- Image Container -->
        <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
            <img id="modal-payment-image" src="" alt="Bukti Pembayaran" class="w-full h-auto max-h-[80vh] object-contain">
        </div>
    </div>
</div>

<script>
function openPaymentProofModal(imageUrl) {
    // Set image
    document.getElementById('modal-payment-image').src = imageUrl;
    
    // Show modal
    document.getElementById('paymentProofModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePaymentProofModal() {
    document.getElementById('paymentProofModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePaymentProofModal();
    }
});
</script>
