document.addEventListener("DOMContentLoaded", () => {
    // Simulasi notifikasi jika di halaman utama
    if (window.location.pathname === "/melatiks/") {
        showToast("Selamat datang di aplikasi Melatiks!");
    }
});

function showToast(message) {
    const toast = document.createElement("div");
    toast.textContent = message;
    toast.style.position = "fixed";
    toast.style.bottom = "20px";
    toast.style.right = "20px";
    toast.style.background = "#004466";
    toast.style.color = "#fff";
    toast.style.padding = "10px 15px";
    toast.style.borderRadius = "6px";
    toast.style.boxShadow = "0 2px 6px rgba(0,0,0,0.3)";
    toast.style.zIndex = 9999;
    toast.style.opacity = 0;
    toast.style.transition = "opacity 0.3s ease";
    document.body.appendChild(toast);
    setTimeout(() => (toast.style.opacity = 1), 100);
    setTimeout(() => {
        toast.style.opacity = 0;
        setTimeout(() => toast.remove(), 500);
    }, 4000);
}
