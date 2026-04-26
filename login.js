// script.js

// Fungsi untuk menukar form Login dan Register
function toggleForms(formType) {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    if (formType === 'register') {
        loginForm.classList.remove('active-form');
        loginForm.classList.add('hidden-form');
        
        setTimeout(() => {
            registerForm.classList.remove('hidden-form');
            registerForm.classList.add('active-form');
        }, 100);
    } else {
        registerForm.classList.remove('active-form');
        registerForm.classList.add('hidden-form');
        
        setTimeout(() => {
            loginForm.classList.remove('hidden-form');
            loginForm.classList.add('active-form');
        }, 100);
    }
}

// Fungsi demo notifikasi (Nanti ini akan diganti oleh proses PHP)
function handleDemoSubmit(event, type) {
    event.preventDefault();
    
    const messageDiv = document.createElement('div');
    messageDiv.className = 'fixed top-5 right-5 bg-slate-800 text-white px-6 py-4 rounded-lg shadow-xl z-50 transform transition-all duration-300 border-l-4 border-blue-500 flex items-center gap-3';
    
    const iconSvg = `<svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;

    if(type === 'login') {
        messageDiv.innerHTML = `${iconSvg} <div><h4 class="font-semibold">Berhasil!</h4><p class="text-sm text-gray-300">Login simulasi berhasil.</p></div>`;
    } else {
        messageDiv.innerHTML = `${iconSvg} <div><h4 class="font-semibold">Berhasil!</h4><p class="text-sm text-gray-300">Akun simulasi dibuat. Silakan login.</p></div>`;
        setTimeout(() => toggleForms('login'), 2000);
    }

    document.body.appendChild(messageDiv);

    setTimeout(() => {
        messageDiv.style.opacity = '0';
        messageDiv.style.transform = 'translateY(-20px)';
        setTimeout(() => messageDiv.remove(), 300);
    }, 3000);
}