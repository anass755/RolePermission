import './bootstrap';

// Import jQuery
import $ from 'jquery';

// Make jQuery globally available
window.$ = window.jQuery = $;

// Your custom JavaScript code here
$(document).ready(function() {
    console.log('jQuery is loaded and ready!');
    
    // Example jQuery code
    // $('button').click(function() {
    //     alert('Button clicked!');
    // });
});