<!-- Modal E-Ticket -->
<div id="ticketModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2 shadow-2xl rounded-2xl bg-white">
        <!-- Modal Header -->
        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">E-Ticket Event</h3>
                    <p class="text-sm text-gray-500">Tiket Digital Anda</p>
                </div>
            </div>
            <button onclick="closeTicketModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="mt-6 space-y-6">
            <!-- Ticket Card -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border-2 border-dashed border-blue-300">
                <!-- Event Info -->
                <div class="mb-6">
                    <h2 id="ticket-event-title" class="text-2xl font-bold text-gray-900 mb-3"></h2>
                    <div class="space-y-2">
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-calendar-alt w-6 text-blue-600"></i>
                            <span id="ticket-event-date" class="ml-2"></span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-map-marker-alt w-6 text-blue-600"></i>
                            <span id="ticket-event-location" class="ml-2"></span>
                        </div>
                    </div>
                </div>
                
                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-blue-300 border-dashed"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-3 bg-gradient-to-br from-blue-50 to-indigo-50 text-sm text-gray-500">
                            Informasi Peserta
                        </span>
                    </div>
                </div>
                
                <!-- Participant Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-white rounded-lg p-4">
                        <p class="text-xs text-gray-500 mb-1">Nama Peserta</p>
                        <p id="ticket-participant-name" class="font-semibold text-gray-900"></p>
                    </div>
                    <div class="bg-white rounded-lg p-4">
                        <p class="text-xs text-gray-500 mb-1">Email</p>
                        <p id="ticket-participant-email" class="font-semibold text-gray-900 text-sm"></p>
                    </div>
                </div>
                
                <!-- QR Code Section -->
                <div class="bg-white rounded-xl p-6 text-center">
                    <p class="text-sm text-gray-600 mb-4">Scan QR Code untuk Check-in</p>
                    <div class="flex justify-center mb-4">
                        <div id="ticket-qrcode" class="bg-white p-4 rounded-lg inline-block"></div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 mb-1">Kode Registrasi</p>
                        <p id="ticket-registration-code" class="text-lg font-mono font-bold text-blue-600"></p>
                    </div>
                </div>
            </div>
            
            <!-- Important Notice -->
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                <div class="flex gap-3">
                    <i class="fas fa-info-circle text-amber-600 mt-1"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-amber-900 mb-1">Penting!</h4>
                        <ul class="text-sm text-amber-800 space-y-1">
                            <li>• Tunjukkan QR Code ini saat check-in</li>
                            <li>• Simpan tiket ini atau download untuk berjaga-jaga</li>
                            <li>• Tiket hanya berlaku untuk satu orang</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 mt-6">
            <a id="ticket-download-link" href="" target="_blank"
               class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-download mr-2"></i>
                Download E-Ticket (PDF)
            </a>
            <button onclick="printTicket()" 
                    class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-print mr-2"></i>
                Print Tiket
            </button>
            <button onclick="closeTicketModal()" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- QR Code Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
function openTicketModal(registrationCode, eventTitle, eventDate, eventLocation, participantName, participantEmail) {
    // Set event info
    document.getElementById('ticket-event-title').textContent = eventTitle;
    document.getElementById('ticket-event-date').textContent = eventDate;
    document.getElementById('ticket-event-location').textContent = eventLocation;
    
    // Set participant info
    document.getElementById('ticket-participant-name').textContent = participantName;
    document.getElementById('ticket-participant-email').textContent = participantEmail;
    document.getElementById('ticket-registration-code').textContent = registrationCode;
    
    // Set download link
    document.getElementById('ticket-download-link').href = '/my-tickets/' + registrationCode + '/download';
    
    // Clear previous QR code
    document.getElementById('ticket-qrcode').innerHTML = '';
    
    // Generate QR Code
    new QRCode(document.getElementById('ticket-qrcode'), {
        text: registrationCode,
        width: 200,
        height: 200,
        colorDark: '#1e40af',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.H
    });
    
    // Show modal
    document.getElementById('ticketModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeTicketModal() {
    document.getElementById('ticketModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function printTicket() {
    window.print();
}

// Close modal when clicking outside
document.getElementById('ticketModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeTicketModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTicketModal();
    }
});
</script>

<!-- Print Styles -->
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #ticketModal, #ticketModal * {
        visibility: visible;
    }
    #ticketModal {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        background: white;
    }
    button, .hidden {
        display: none !important;
    }
}
</style>
