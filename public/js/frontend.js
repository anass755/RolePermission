$(document).ready(function(){
	$(".wish-icon i").click(function(){
		$(this).toggleClass("fa-heart fa-heart-o");
	});
});	
// navbar
const navLinks = document.querySelector('.nav-links');
const toggleButton = document.createElement('div');
toggleButton.classList.add('toggle-button');
toggleButton.innerHTML = '&#9776;'; // Hamburger icon
document.querySelector('.navbar').appendChild(toggleButton);

toggleButton.addEventListener('click', () => {
  navLinks.classList.toggle('active');
});
// navbar