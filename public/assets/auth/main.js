        // Custom checkbox functionality
        document.getElementById('rememberCheck').addEventListener('click', function() {
            this.classList.toggle('checked');
        });
           setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            el.style.transition = "opacity 0.5s ease";
            el.style.opacity = "0";
            setTimeout(() => el.remove(), 500);
        });
    }, 5000);

      document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const loginBtn = document.getElementById('loginBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const loginText = document.getElementById('loginText');
    const form = this;

    loginBtn.disabled = true;
    loadingSpinner.style.display = 'inline-block';
    loginText.textContent = 'Memverifikasi...';

    setTimeout(() => {
        form.submit(); // submit form ke server Laravel
    }, 500); // animasi singkat sebelum submit
});

        // Biometric login handlers
        function setupBiometricButton(buttonId, message) {
            const button = document.getElementById(buttonId);
            
            button.addEventListener('click', handleBiometric);
            button.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    handleBiometric.call(this);
                }
            });

            function handleBiometric() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                    alert(message);
                }, 100);
            }
        }

        setupBiometricButton('fingerprintBtn', 'Fitur sidik jari akan segera tersedia!');
        setupBiometricButton('faceIdBtn', 'Fitur Face ID akan segera tersedia!');
        setupBiometricButton('qrCodeBtn', 'Fitur QR Code akan segera tersedia!');

        // Forgot password handler
        document.querySelector('.forgot-password').addEventListener('click', function(e) {
            e.preventDefault();
            alert('Link reset password akan dikirim ke email yang terdaftar.');
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'Enter') {
                document.getElementById('loginForm').dispatchEvent(new Event('submit'));
            }
        });

        // Auto-focus first input
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('email').focus();
        });

        // Real-time validation
        document.getElementById('email').addEventListener('input', function() {
            const isValid = this.value.includes('@') || this.value.length >= 3;
            this.style.borderColor = isValid ? '#e5e7eb' : '#ef4444';
        });

        document.getElementById('password').addEventListener('input', function() {
            const isValid = this.value.length >= 6;
            this.style.borderColor = isValid ? '#e5e7eb' : '#ef4444';
        });