document.addEventListener('DOMContentLoaded', () => {
  console.log('custom js for this plugin is now loaded, do something!');
}, false);


const inputs = document.getElementsByName('jobStatus');
// const labels = inputs.querySelectorAll('label');
inputs.forEach((input) => {
  const thisthing = input.nextElementSibling;
  thisthing.style.color = 'blue';
});
