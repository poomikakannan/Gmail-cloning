function togglePopup() {
    const popup = document.getElementById('profilePopup');
    popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
}

// Close the popup when clicking outside of it
window.onclick = function(event) {
    const popup = document.getElementById('profilePopup');
    if (event.target !== popup && event.target !== document.querySelector('.profile-icon')) {
        popup.style.display = 'none';
    }
};
