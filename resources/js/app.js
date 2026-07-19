import './bootstrap';
import '@fontsource/poppins/latin-300.css';
import '@fontsource/poppins/latin-400.css';
import '@fontsource/poppins/latin-500.css';
import '@fontsource/poppins/latin-600.css';
import '@fontsource/poppins/latin-700.css';
import '@fontsource/poppins/latin-800.css';
import '@fontsource/poppins/latin-900.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import 'quill/dist/quill.snow.css';

import Alpine from 'alpinejs';
import QRCode from 'qrcodejs';
import Quill from 'quill';

window.Alpine = Alpine;
window.QRCode = QRCode;
window.Quill = Quill;

Alpine.start();
