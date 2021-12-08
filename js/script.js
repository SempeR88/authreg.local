document.addEventListener('DOMContentLoaded', function() {
	let successMessage = document.querySelector('.success-message');
	if (successMessage !== null) {
		setTimeout(function() {
			successMessage.style.display = 'none';
		}, 5000);
	}
});